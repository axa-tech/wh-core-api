<?php

namespace Axa\Bundle\WhapiBundle\Service;

use Axa\Bundle\WhapiBundle\Entity\Vm;
use Axa\Bundle\WhapiBundle\Entity\VmQueue;
use Axa\Bundle\WhapiBundle\Entity\VmRepository;
use Axa\Bundle\WhapiBundle\Utility\Request;
use OldSound\RabbitMqBundle\RabbitMq\Producer;


class VirtualMachineService
{
    use Request;

    /**
     * @var \Axa\Bundle\WhapiBundle\Entity\VmRepository
     */
    private $vmRepository;

    /**
     * @var \OldSound\RabbitMqBundle\RabbitMq\Producer
     */
    private $baseProducer;


    public function __construct(VmRepository $vmRepository, Producer $baseProducer)
    {
        $this->vmRepository = $vmRepository;
        $this->baseProducer = $baseProducer;
    }

    /**
     * Update Vm's and VmMetadata properties
     *
     * @param Vm $vm
     * @param array $metadata
     */
    public function update(Vm $vm, array $metadata)
    {
        $this->updateVm($vm, $metadata);
        $this->updateOrCreateMetadata($vm, $metadata);
    }

    /**
     * Update Vm Properties
     *
     * @param Vm $vm
     * @param array $metadata
     */
    private function updateVm(Vm $vm, array & $metadata)
    {
        if (isset($metadata['platform_id'])) {
            unset($metadata['platform_id']);
        }

        if (isset($metadata['instanceName'])) {
            $vm->setInstanceName($metadata['instanceName']);
            unset($metadata['instanceName']);
        }

        if (isset($metadata['providerId'])) {
            $vm->setRemoteId($metadata['providerId']);
            unset($metadata['providerId']);
        }

        if (isset($metadata['ipAddress'])) {
            $vm->setIpAddress($metadata['ipAddress']);
            unset($metadata['ipAddress']);
        }

        if (isset($metadata['status'])) {
            $vm->setStatus($metadata['status']);
            unset($metadata['status']);
        }

        $this->vmRepository->persist($vm);
        $vm->getPlatform()->updateStatus();

        $this->vmRepository->persist($vm->getPlatform());
    }

    /**
     * Update or create VmMetadata
     *
     * @param Vm $vm
     * @param array $metadata
     */
    private function updateOrCreateMetadata(Vm $vm, array $metadata)
    {
        $metadata = $this->sanitizeData($metadata);

        foreach($metadata as $name => $value) {
            $this->vmRepository->updateOrCreateMetadata($vm, $name, $value);
        }
    }

    /**
     * Create the vm's queue
     *
     * @param Vm $vm
     * @return VmQueue
     */
    public function createQueue(Vm $vm)
    {
        if (! $vm->getQueue()) {
            $queueName = $vm->getPlatform()->getId() . "_" . $vm->getId() . "_" . $vm->getInstanceName();

            $this->baseProducer->setExchangeOptions(array(
                "name"  => $queueName,
                "type"  => "direct"
            ));

            $this->baseProducer->setQueueOptions(array(
                "name" => $queueName
            ));

            $this->baseProducer->setupFabric();
            $queue = new VmQueue();
            $queue->setName($queueName);
            $queue->setVm($vm);
            $vm->setQueue($queue);

            $this->vmRepository->persist($vm);
        }

        return $vm->getQueue();
    }
}