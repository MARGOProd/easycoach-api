<?php

namespace App\Command;

use Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity\Exercice;
use App\Entity\ExerciceMuscle;
use App\Entity\GroupeMusculaire;
use App\Entity\Muscle;

class ImportExerciceCommand extends Command
{
    protected static $defaultName = 'app:import-exercice';
    protected static $defaultDescription = 'Add a short description for your command';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
            ->setDescription(self::$defaultDescription)
            ->addArgument('filename', InputArgument::REQUIRED, 'FileName of the XLSX file.');
    }

    private function generateExercice(Exercice $exercice = null, $value)
    {
        $exercice = new Exercice();
        $exercice->setLibelle($value['libelle']);
        $this->em->persist($exercice);
        $this->em->flush();
        return $exercice;
    }

    private function generateExerciceMuscle(Exercice $exercice, Muscle $muscle, $value)
    {
        $exerciceMuscle = new ExerciceMuscle();
        $exerciceMuscle->setExercice($exercice);
        $exerciceMuscle->setMuscle($muscle);
        $exerciceMuscle->setIsDirect($value['is_direct']);
        $this->em->persist($exerciceMuscle);
        $this->em->flush();
        return $exerciceMuscle;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filename = $input->getArgument('filename');
        $commandStatus = Command::SUCCESS;

        if ($filename) {
            try {
                $csv = Reader::createFromPath('public/assets/imports/' . $filename . '.csv', 'r');
                $csv->setHeaderOffset(0);
                $records = $csv->getRecords();

                $muscleRepository = $this->em->getRepository(Muscle::class);
                $exerciceRepository = $this->em->getRepository(Exercice::class);
                $exerciceMuscleRepository = $this->em->getRepository(ExerciceMuscle::class);
                $groupeMuscleRepository = $this->em->getRepository(GroupeMusculaire::class);
                
                foreach ($records as $key => $value) {
                    $exercice = $exerciceRepository->findOneBy(['libelle' => $value["libelle"]]);
                    $groupeMuscle = $groupeMuscleRepository->find($value['groupe_musculaire_id']);
                    $muscles = $groupeMuscle->getMuscles();
                    if(!empty($muscles))
                    {
                        if(is_null($exercice))
                        {
                            // l'exercice n'héxiste pas. Je le créer et créer la liaison exercice muscle.
                            $exercice = $this->generateExercice($exercice, $value);
                            $io->success("create ExerciceMuscle 1");
                                foreach($muscles as $muscle)
                                {
                                    $this->generateExerciceMuscle($exercice, $muscle, $value);
                                }
                        }else{
                            foreach($muscles as $muscle)
                            {
                                $exerciceMuscle = $exerciceMuscleRepository->findOneBy(['exercice' => $exercice->getId(), 'muscle' =>$muscle->getId(), 'isDirect' => $value["is_direct"]]);
                                if(is_null($exerciceMuscle))
                                {
                                    $this->generateExerciceMuscle($exercice, $muscle, $value);
                                    $io->success("create ExerciceMuscle 1");
                                }else{
                                    $io->error("ExerciceMuscle Exist");
                                }
                            }
                        }
                    }else{
                        $io->error('Any muscle associate with this muscular group : ' . $value['groupe_musculaire_id'].'. Check if muscular group exist');
                    }
                }
            } catch (UnavailableStream $e) {
                $io->error("The filename doesn't exist");
                $commandStatus = Command::FAILURE;
            } catch (Exception $e) {
                $io->error("Record " . $key . ": " .$e->getMessage());
                $commandStatus = Command::FAILURE;
            }
        } else {
            $io->error("The filename argument must be provided");
            $commandStatus = Command::FAILURE;
        }
        return $commandStatus;
    }
}
