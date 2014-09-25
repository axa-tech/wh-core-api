<?php

namespace Axa\Bundle\WhapiBundle\Service;

use Axa\Bundle\WhapiBundle\Entity\Vm;
use Axa\Bundle\WhapiBundle\Entity\VmRepository;
use Axa\Bundle\WhapiBundle\Utility\Request;


class VirtualMachineService
{
    use Request;

    /**
     * @var \Axa\Bundle\WhapiBundle\Entity\VmRepository
     */
    private $vmRepository;


    public function __construct(VmRepository $vmRepository)
    {
        $this->vmRepository = $vmRepository;
    }

    /**
     * Update or create vm's metadata
     *
     * @param Vm $vm
     * @param array $metadata
     */
    public function update(Vm $vm, array $metadata)
    {
        if(isset($metadata['platform_id'])) {
            unset($metadata['platform_id']);
        }

        $metadata = $this->sanitizeData($metadata);

        foreach($metadata as $name => $value) {
            $this->vmRepository->updateOrCreateMetadata($vm, $name, $value);
        }
    }
}