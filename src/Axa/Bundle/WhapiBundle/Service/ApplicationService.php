<?php

namespace Axa\Bundle\WhapiBundle\Service;


use Axa\Bundle\WhapiBundle\Entity\Application;
use Axa\Bundle\WhapiBundle\Entity\ApplicationRepository;
use Axa\Bundle\WhapiBundle\Entity\Container;
use Axa\Bundle\WhapiBundle\Entity\Platform;
use Axa\Bundle\WhapiBundle\Entity\Stack;
use Axa\Bundle\WhapiBundle\Exception\LogicException;
use Axa\Bundle\WhapiBundle\Exception\OutOfMemoryException;
use Axa\Bundle\WhapiBundle\Exception\OutOfPortLimitException;

class ApplicationService
{

    /**
     * @var \Axa\Bundle\WhapiBundle\Entity\ApplicationRepository
     */
    private $applicationRepository;

    /**
     * @var int
     */
    private $defaultContainerMemory;

    /**
     * @var int
     */
    private $containerMinPort;

    /**
     * @var int
     */
    private $containerMaxPort;


    public function __construct(
        ApplicationRepository $applicationRepository,
        $defaultContainerMemory,
        $containerMinPort,
        $containerMaxPort
    )
    {
        $this->applicationRepository    = $applicationRepository;
        $this->defaultContainerMemory   = $defaultContainerMemory;
        $this->containerMinPort         = $containerMinPort;
        $this->containerMaxPort         = $containerMaxPort;
    }

    /**
     * Create a new application
     *
     * @param Platform $platform
     * @param Stack $stack
     * @param $name
     * @param $url
     * @param $topology
     * @returns Application
     */
    public function create(Platform $platform, Stack $stack, $name, $url, $topology)
    {
        $application = new Application();
        $application->setName($name)
            ->setPlatform($platform)
            ->setStack($stack)
            ->setUrl($url)
            ->setStatus(Application::STATUS_TO_DO)
            ->setTopology($topology);

        while($topology) {
            $container = $this->createContainer($application);
            $application->addContainer($container);
            $topology--;
        }

        $this->applicationRepository->persist($application);

        return $application;
    }

    /**
     * Create a container for a given application
     *
     * @param Application $application
     * @throws \Axa\Bundle\WhapiBundle\Exception\LogicException
     * @returns Container
     */
    public function createContainer(Application $application)
    {
        $targetVirtualMachine = $this->getTargetVirtualMachine($application);
        $container = new Container();
        $container->setApplication($application)
            ->setVm($targetVirtualMachine)
            ->setStatus(Container::STATUS_IN_PROGRESS)
            ->setMemoryLimit($this->defaultContainerMemory);

        $port = $this->getFreePort($application->getPlatform());

        if (!$port) {
            throw new OutOfPortLimitException(
                sprintf("No port available in the platform %d ", $application->getPlatform()->getId())
            );
        }

        $container->setPort($port);

        return $container;
    }

    /**
     * Returns the virtual machine in which the application will be installed
     *
     * @param Application $application
     * @throws \Axa\Bundle\WhapiBundle\Exception\LogicException
     * @throws \Axa\Bundle\WhapiBundle\Exception\OutOfMemoryException
     *
     * @return \Axa\Bundle\WhapiBundle\Entity\Vm
     */
    private function getTargetVirtualMachine(Application $application)
    {
        $virtualMachines = $application->getPlatform()->getVirtualMachines();

        if (!$virtualMachines->count()) {
            throw new LogicException("No Virtual machine available");
        }

        $availableVirtualMachines = array();

        foreach($virtualMachines as $virtualMachine) {

            if ($virtualMachine->getAvailableMemory() > $this->defaultContainerMemory) {
                $availableVirtualMachines[] = $virtualMachine;
            }
        }

        if (!count($availableVirtualMachines)) {
            throw new OutOfMemoryException(
                sprintf("Not enough memory in the platform %d ", $application->getPlatform()->getId())
            );
        }

        $targetVirtualMachine = $availableVirtualMachines[0];

        foreach($availableVirtualMachines as $availableVirtualMachine) {

            if ($availableVirtualMachine->getAvailableMemory() > $targetVirtualMachine->getAvailableMemory()) {
                $targetVirtualMachine = $availableVirtualMachine;
            }
        }

        return $targetVirtualMachine;
    }

    /**
     * Get a free port for a given platform
     *
     * @param Platform $platform
     * @return int
     */
    public function getFreePort(Platform $platform)
    {
        $usedPorts = $platform->getApplicationsPorts();

        do {
            $port = mt_rand($this->containerMinPort, $this->containerMaxPort);

        } while(in_array($port, $usedPorts));

        return $port;
    }

    /**
     *
     * @param Application $application
     * @return array
     */
    public function getAmqpCreateMessage(Application $application)
    {

    }
}