<?php

namespace Axa\Bundle\WhapiBundle\Service;


use Axa\Bundle\WhapiBundle\Entity\Platform;
use Axa\Bundle\WhapiBundle\Entity\PlatformRepository;
use Axa\Bundle\WhapiBundle\Entity\DockerRepository;
use Axa\Bundle\WhapiBundle\Entity\VmRepository;
use Axa\Bundle\WhapiBundle\Exception\EntityNotFoundException;
use Axa\Bundle\WhapiBundle\Exception\LogicException;

class DockerService
{

    /**
     * @var \Axa\Bundle\WhapiBundle\Entity\DockerRepository
     */
    private $dockerRepository;

    /**
     * @var \Axa\Bundle\WhapiBundle\Entity\PlatformRepository
     */
    private $platformRepository;

    /**
     * @var \Axa\Bundle\WhapiBundle\Entity\VmRepository
     */
    private $vmRepository;


    public function __construct(
        DockerRepository $dockerRepository,
        PlatformRepository $platformRepository,
        VmRepository $vmRepository
    )
    {
        $this->dockerRepository     = $dockerRepository;
        $this->platformRepository   = $platformRepository;
        $this->vmRepository         = $vmRepository;
    }

    /**
     * Add a docker into a platform
     *
     * @param $platformId
     * @param $dockerCode
     * @throws \Axa\Bundle\WhapiBundle\Exception\LogicException
     * @throws \Axa\Bundle\WhapiBundle\Exception\EntityNotFoundException
     */
    public function create($platformId, $dockerCode)
    {
        $platform = $this->platformRepository->find($platformId);

        if (!$platform) {
            throw new EntityNotFoundException("Platform", $platformId);
        }

        $docker = $this->dockerRepository->findOneBy(array('code'=> $dockerCode));

        if (!$docker) {
            throw new EntityNotFoundException("Docker", $dockerCode);
        }

        $virtualMachines = $platform->getVirtualMachines();

        if (!$virtualMachines->count()) {
            throw new LogicException("No Virtual machine available");
        }

        $targetVirtualMachine = $virtualMachines->first();

        foreach($virtualMachines as $virtualMachine) {
            if($virtualMachine->getgetDockers()->count() < $targetVirtualMachine->getDockers()->count()) {
                $targetVirtualMachine = $virtualMachine;
            }
        }

        $targetVirtualMachine->addDocker($docker);

        $this->vmRepository->persist($targetVirtualMachine);

    }

    /**
     * Builds and returns the amqp message content that will be sent to the broker in order to create the platform
     *
     * @param Vm $vm
     * @return array
     */
    public function getAmqpCreateMessage(Vm $vm)
    {

    }
}