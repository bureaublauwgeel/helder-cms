<?php

use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\FixturesBundle\Command\LoadDataFixturesDoctrineCommand;
use Doctrine\Bundle\MigrationsBundle\Command\MigrationsMigrateDoctrineCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * @SuppressWarnings(PHPMD)
 */
class TestListener implements PHPUnit_Framework_TestListener
{
    /**
     * @param PHPUnit_Framework_Test $test
     * @param Exception              $e
     * @param float                  $time
     */
    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        printf("Error while running test '%s'.\n", $test->getName());
    }

    /**
     * @param PHPUnit_Framework_Test                 $test
     * @param PHPUnit_Framework_AssertionFailedError $e
     * @param float                                  $time
     */
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        printf("Test '%s' failed.\n", $test->getName());
    }

    /**
     * @param PHPUnit_Framework_Test $test
     * @param Exception              $e
     * @param float                  $time
     */
    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        printf("Test '%s' is incomplete.\n", $test->getName());
    }

    /**
     * @param PHPUnit_Framework_Test $test
     * @param Exception              $e
     * @param float                  $time
     */
    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        printf("Test '%s' is deemed risky.\n", $test->getName());
    }

    /**
     * @param PHPUnit_Framework_Test $test
     * @param Exception              $e
     * @param float                  $time
     */
    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        printf("Test '%s' has been skipped.\n", $test->getName());
    }

    /**
     * @param PHPUnit_Framework_Test $test
     */
    public function startTest(PHPUnit_Framework_Test $test)
    {
        printf("Test '%s' started.\n", $test->getName());
    }

    /**
     * @param PHPUnit_Framework_Test $test
     * @param float                  $time
     */
    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        printf("Test '%s' ended.\n", $test->getName());
    }

    /**
     * @param PHPUnit_Framework_TestSuite $suite
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        $kernel = new AppKernel('test', true); // create a "test" kernel
        $kernel->boot();

        $application = new Application($kernel);

// add the database:drop command to the application and run it
        $command = new DropDatabaseDoctrineCommand();
        $command->setContainer($kernel->getContainer());
        $application->add($command);
        $input = new ArrayInput(
            [
                'command' => 'doctrine:database:drop',
                '--force' => true,
            ]
        );
        $command->run($input, new ConsoleOutput());


        // This stops a bug where Drop Database does not close the handle properly & causes subsequent
        // "database not found" errors.
        $connection = $kernel->getContainer()->get('doctrine')->getConnection();
        if ($connection->isConnected()) {
            $connection->close();
        }
        // add the database:create command to the application and run it
        $command = new CreateDatabaseDoctrineCommand();
        $command->setContainer($kernel->getContainer());
        $application->add($command);
        $input = new ArrayInput(
            [
                'command' => 'doctrine:database:create',
            ]
        );
        $command->run($input, new ConsoleOutput());
        // Run the database migrations, with --quiet because they are quite
        // chatty on the console.
        $command = new MigrationsMigrateDoctrineCommand();
        $application->add($command);
        $input = new ArrayInput(
            [
                'command'          => 'doctrine:migrations:migrate',
                '--quiet'          => false,
                '--no-interaction' => true,
            ]
        );
        $input->setInteractive(false);
        $command->run($input, new ConsoleOutput(ConsoleOutput::VERBOSITY_QUIET));
        // and load the fixtures
        $command = new LoadDataFixturesDoctrineCommand();
        $command->setContainer($kernel->getContainer());
        $application->add($command);
        $input = new ArrayInput(
            [
                'command' => 'doctrine:fixtures:load',
                '--quiet',
            ]
        );
        $input->setInteractive(false);
        $command->run($input, new ConsoleOutput());
    }

    /**
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        printf("TestSuite '%s' ended.\n", $suite->getName());
    }
}
