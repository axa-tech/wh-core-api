<?php

namespace Axa\Bundle\WhapiBundle\Platform;

use Axa\Bundle\WhapiBundle\Entity\OfferRepository;
use Axa\Bundle\WhapiBundle\Entity\Platform;
use Axa\Bundle\WhapiBundle\Entity\PlatformRepository;
use Axa\Bundle\WhapiBundle\Entity\UserRepository;
use Axa\Bundle\WhapiBundle\Entity\Vm;
use Axa\Bundle\WhapiBundle\Exception\OfferNotFoundException;

class PlatformService
{
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
                ->setOffer($offer);

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
        $vm1 = new Vm();
        $vm2 = new Vm();
        $vm1->setPlatform($platform);
        $vm2->setPlatform($platform);
        $platform->getVirtualMachines()->add($vm1);
        $platform->getVirtualMachines()->add($vm2);
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

            $vmMetaData = array(
                'id'        => $virtualMachine->getId(),
                'adminPass' => 'defaultAdminPass',
                'name'      => 'the vm name',
            );

            $vms[] = array_merge($vmMetaData, $vmTemplate);
        }

        return array(
            'platformId'    => "1234",
            'vms'           => $vms
        );
    }
}