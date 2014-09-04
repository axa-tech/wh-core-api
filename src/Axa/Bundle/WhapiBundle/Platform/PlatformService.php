<?php

namespace Axa\Bundle\WhapiBundle\Platform;

use Axa\Bundle\WhapiBundle\Entity\OfferRepository;
use Axa\Bundle\WhapiBundle\Entity\Platform;
use Axa\Bundle\WhapiBundle\Entity\PlatformRepository;
use Axa\Bundle\WhapiBundle\Entity\UserRepository;
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

        $this->platformRepository->persist($platform);

        return $platform;
    }
}