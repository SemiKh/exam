<?php

namespace App\Controller\Front;

use App\Entity\Listing;
use App\Form\ListingType;
use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/listing', name: 'app_listing_')]
class ListingController extends AbstractController
{
    public function __construct(
        private ListingRepository $listingRepository
    ) {
    }

    #[Route('/new', name:'new')]
    public function newList(Request $request){
        $listing = new Listing();
        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->listingRepository->save($listing, true);
            $listing->setCreatedAt(new \DateTime);
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('front/pages/listing/new.html.twig', [
            
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(int $id): Response
    {
        $listing = $this->listingRepository->findOneBy(['id' => $id]);

        return $this->render('front/pages/listing/index.html.twig', [
            'listing' => $listing,
        ]);
    }
}   