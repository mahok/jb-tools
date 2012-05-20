<?php

namespace Mahok\JbTools\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Finder\Finder;
use Mahok\JbTools\Gallery\Gallery;

/**
 * Imports SimpleViewer2-galleries to Juicebox.
 *
 * Looks for gallery.xml in specified source-folder and converts it into the
 * new config.xml-format. No existing data is changed, thus it can be used with
 * either SimpleViewer2 or Juicebox.
 */
class Import extends Command
{
    protected function configure()
    {
        $this
            ->setName('jb:import')
            ->setDescription('Imports data from old gallery.xml into a new config.xml')
            ->addArgument('source', InputArgument::REQUIRED, 'Source folder containing sv2-gallery/galleries')
            ->addOption('depth', 'd', InputOption::VALUE_OPTIONAL, 'Look into subfolders up to this depth', 0)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputPath  = realpath($input->getArgument('source'));
        if (false === $inputPath) {
            throw new \InvalidArgumentException('Invalid source folder specified!');
        }
        $depth      = $input->getOption('depth');
        if ($depth < 0) {
            $depth = 0;
        }

        $finder = new Finder();
        $finder->files()->name('gallery.xml')->in($inputPath)->depth($depth);

        $countImports = 0;
        foreach ($finder as $file) {
            $basePath = substr($file->getPathname(), 0, strlen($file->getPathname()) - strlen($file->getFilename()));
            $output->write("Processing '<info>{$basePath}</info>'...");
            $gallery = Gallery::importFromSv2($file->getPathname());
            $gallery->save();
            $countImports++;
            $output->writeln(" done.");
        }
        $output->writeln("\n<info>{$countImports}</info> galleries were migrated to Juicebox.");
    }
}