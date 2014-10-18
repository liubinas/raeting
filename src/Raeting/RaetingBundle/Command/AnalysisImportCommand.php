<?php
namespace Raeting\RaetingBundle\Command;

use Raeting\RaetingBundle\Entity\Analyst as AnalystEntity;

use Raeting\RaetingBundle\Service\FileManagement;
use Raeting\RaetingBundle\Service\Analysis;
use Raeting\RaetingBundle\Service\Analyst;
use Raeting\RaetingBundle\Service\Symbol;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AnalysisImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('raeting:analysis:import')
             ->setDescription('Imports analysis');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Analysis */
        $analysisService = $this->getContainer()->get('raetingraeting.service.analysis');
        /** @var Analyst */
        $analystService = $this->getContainer()->get('raetingraeting.service.analyst');
        /** @var FileManagement */
        $fileManagementService = $this->getContainer()->get('raetingraeting.service.file_management');
        /** @var string */
        $sourceDir = dirname($this->getContainer()->get('kernel')->getRootDir()) . '/uploads/analysis';
        /** @var string */
        $archiveDir = dirname($this->getContainer()->get('kernel')->getRootDir()) . '/uploads/archive/analysis';

        //$objPHPExcel = new \PHPExcel();

        $files = $fileManagementService->scanDir($sourceDir);
        if (empty($files)) {
            $output->writeln(sprintf('<error>No files found under %s</error>', $sourceDir));
            return;
        }

        $totalInsertsDone = 0;
        $filesInserted = 0;

        $output->writeln('<info>Importing analysis...</info>');

        foreach ($files as $file) {

            $symbol = $this->getSymbolByFilename($file);
            if (!$symbol) {
                $output->writeln(sprintf('<error>File %s does not match any symbol in DB</error>', basename($file)));
                continue;
            }

            try {
                $objPHPExcel = $this->loadFile($file);
            } catch (\Exception $e) {
                $output->writeln(
                    sprintf('<error>Error loading file %s, message: %s</error>', $sourceDir, $e->getMessage())
                );
                continue;
            }

            $insertsFromFile = 0;

            $loadedSheetNames = $objPHPExcel->getSheetNames();
            foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                try {
                    $sheetData = $objPHPExcel->getSheet($sheetIndex)->toArray(null,true,true,true);
                } catch (\Exception $e) {
                    $output->writeln(
                        sprintf('<error>Error loading sheet "%s": %s</error>', $loadedSheetName, $e->getMessage())
                    );
                    continue;
                }

                try {
                    $analyst = $this->extractAnalyst($sheetData);
                } catch (\InvalidArgumentException $e) {
                    $output->writeln(
                        sprintf('<error>No analyst data found in the sheet: %s</error>', $loadedSheetName)
                    );
                    continue;
                }

                foreach ($sheetData as $rowNum => $row) {
                    if ($rowNum < 5) {
                        continue;
                    }

                    $data = array(
                        'recommendation' => $row['A'],
                        'date'           => \DateTime::createFromFormat('m/d/y', $row['B'])->format('Y-m-d'),
                        'estimation'     => $row['C'],
                        'period'         => $row['D'],
                    );

                    if (!empty($data['estimation']) && !empty($data['date'])) {
                        $insertsFromFile += (int) $analysisService->insertData($symbol, $analyst, $data);
                    }
                }
            }

            $totalInsertsDone += $insertsFromFile;
            if ($insertsFromFile > 0){
                $fileManagementService->moveFile($file, $archiveDir . '/' . basename($file));
                $filesInserted++;
            }
        }


        $output->writeln('<info>Files inserted: '.$filesInserted.'.Inserts done: '.$totalInsertsDone.'</info>');
    }

    /**
     * @param string $file
     *
     * @return \PHPExcel
     */
    private function loadFile($file)
    {
        $inputFileType = \PHPExcel_IOFactory::identify($file);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setLoadAllSheets();

        return $objReader->load($file);
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    private function getSymbolByFilename($file)
    {
        /** @var Symbol */
        $symbolService = $this->getContainer()->get('raetingraeting.service.symbol');

        $baseName = basename($file);
        $name = substr($baseName, 0, strpos($baseName, '.'));

        return $symbolService->getBySymbol($name);
    }

    /**
     * @return AnalystEntity
     */
    private function extractAnalyst($sheetData)
    {
        /** @var Analyst */
        $analystService = $this->getContainer()->get('raetingraeting.service.analyst');

        if (empty($sheetData[1]['B'])) {
            throw new \Exception('Analyst name not found');
        }

        if (empty($sheetData[2]['B'])) {
            throw new \Exception('Analyst company not found');
        }

        $name = mb_convert_case($sheetData[1]['B'], MB_CASE_TITLE);
        $company = mb_convert_case($sheetData[2]['B'], MB_CASE_TITLE);

        $analyst = $analystService->getByName($name);
        if (!$analyst) {
            $analyst = $analystService->getNew();
            $analyst->setName($name);
            $analyst->setSlug($this->slugify($name));
            $analyst->setCompany($company);
            $analystService->save($analyst);
        }

        return $analyst;
    }

    private function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            $text = 'n-a';
        }

        return $text;
    }

}