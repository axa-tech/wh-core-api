<?php

namespace Axa\Bundle\WhapiBundle\Service;

use Axa\Bundle\WhapiBundle\Entity\OfferRepository;
use Axa\Bundle\WhapiBundle\Entity\Platform;
use Axa\Bundle\WhapiBundle\Entity\PlatformRepository;
use Axa\Bundle\WhapiBundle\Entity\UserRepository;
use Axa\Bundle\WhapiBundle\Entity\Vm;
use Axa\Bundle\WhapiBundle\Exception\OfferNotFoundException;
use Axa\Bundle\WhapiBundle\Exception\PlatformNotFoundException;
use Axa\Bundle\WhapiBundle\Utility\Request;

class PlatformService
{
    use Request;

    /**
     * @var \Axa\Bundle\WhapiBundle\Entity\UserRepository
     */
    private $userRepository;

    /**
     * @var \Axa\Bundle\WhapiBundle\Entity\PlatformRepository
     */
    private $platformRepository;

    private $offerRepository;

    public function __construct(
        UserRepository $userRepository,
        PlatformRepository $platformRepository,
        OfferRepository $offerRepository
    )
    {
        $this->userRepository       = $userRepository;
        $this->platformRepository   = $platformRepository;
        $this->offerRepository      = $offerRepository;
    }

    /**
     * Create a new Platform
     *
     * @param $userEmail
     * @param $offerCode
     * @return Platform
     * @throws \Axa\Bundle\WhapiBundle\Exception\OfferNotFoundException
     */
    public function create($userEmail, $offerCode)
    {
        $user = $this->userRepository->findOneByEmailOrCreate($userEmail, true);

        $offer = $this->offerRepository->findOneBy(array("code" => $offerCode));

        if (!$offer) {
            throw new OfferNotFoundException($offerCode);
        }

        $platform = new Platform();
        $platform->setUser($user)
                ->setOffer($offer)
                ->setStatus(Platform::STATUS_IN_PROGRESS);

        $this->createVirtualMachines($platform);
        $this->platformRepository->persist($platform);

        return $platform;
    }

    /**
     * Create two virtual machines for the given platform
     *
     * @param Platform $platform
     */
    private function createVirtualMachines(Platform $platform)
    {
        $nbVm = $platform->getOffer()->getNbVm();
        while($nbVm) {
            $vm = new Vm();
            $vm->setPlatform($platform);
            $platform->getVirtualMachines()->add($vm);
            $nbVm--;
        }
    }

    /**
     * Builds and returns the amqp message content that will be sent to the broker in order to create the platform
     *
     * @param Platform $platform
     * @return array
     */
    public function getAmqpCreateMessage(Platform $platform)
    {
        $offer = $platform->getOffer();
        $vms = array();

        $vmTemplate = array(
            'cpu'       => $offer->getCpu(),
            'memory'    => $offer->getMemory(),
            'storage'   => $offer->getStorage(),
        );

        foreach($platform->getVirtualMachines() as $virtualMachine) {

            $vmData = array(
                'id'        => $virtualMachine->getId(),
                'adminPass' => 'defaultAdminPass',
                'name'      => 'the vm name',
            );

            $vms[] = array_merge($vmData, $vmTemplate);
        }

        return array(
            'platformId'        => $platform->getId(),
            'platformRemoteId'  => "9",
            'vms'               => $vms
        );
    }

    /**
     * Update a platform metada
     *
     * @param Platform $platform
     * @param array $metadata
     */
    public function update(Platform $platform, array $metadata)
    {
        $metadata = $this->sanitizeData($metadata);

        foreach($metadata as $name => $value) {
            $this->platformRepository->updateOrCreateMetadata($platform, $name, $value);
        }
    }

    /**
     * Get a array formatted platform data
     *
     * @param $id the platform id
     * @returns array
     * @throws PlatformNotFoundException
     */
    public function find($id)
    {
        if (!$platform = $this->platformRepository->find($id)) {
            throw new PlatformNotFoundException($id);
        }

        $data = array(
            'id'        => $platform->getId(),
            'userId'    => $platform->getUser()->getId(),
            'offerId'   => $platform->getOffer()->getId(),
            'status'    => $platform->getStatus()
        );

        return array_merge($data, $this->platformRepository->getFormattedMetadata($platform));
    }
}