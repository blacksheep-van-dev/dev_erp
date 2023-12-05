<?php

namespace App\Controller;

use App\Entity\OptionStock;
use App\Entity\Agency;
use App\Entity\Option;
use App\Form\OptionStockType;
use App\Repository\OptionStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/optionstock')]
class OptionStockController extends AbstractController
{
    #[Route('/', name: 'app_option_stock_index', methods: ['GET'])]
    public function index(OptionStockRepository $optionStockRepository): Response
    {
        return $this->render('option_stock/index.html.twig', [
            'option_stocks' => $optionStockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_option_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $optionStock = new OptionStock();
        $form = $this->createForm(OptionStockType::class, $optionStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          // get  form data
            $data = $form->getData();

            // get option id
            $optionId = $data->getOptions()->getId();

            // get agency id
            $agencyId = $data->getAgency()->getId();

            // get agency
            $agency = $entityManager->getRepository(Agency::class)->find($agencyId);

            // get option
            $option = $entityManager->getRepository(Option::class)->find($optionId);

            /// get option stock for a specific agency and option
            $optionStock = $entityManager->getRepository(OptionStock::class)->findOneBy([
                'agency' => $agency,
                'options' => $option
            ]);

            // if option stock exist for a specific agency and option
            if ($optionStock) {
                // update option stock
                $optionStock->setQuantity($data->getQuantity());
                // enabled
                $optionStock->setEnabled($data->isEnabled());
                
                $optionStock->setPrice($data->getPrice());
                $optionStock->setAgency($agency);
                $optionStock->setOptions($option);

                $entityManager->persist($optionStock);
                $entityManager->flush();

                // flash message
                $this->addFlash('warning', 'Option stock updated successfully!');
                return $this->redirectToRoute('app_option_stock_index', [], Response::HTTP_SEE_OTHER);
    
    
            } else {
                // create option stock
                $optionStock = new OptionStock();
                $optionStock->setQuantity($data->getQuantity());

                $optionStock->setEnabled($data->isEnabled());
               
                $optionStock->setPrice($data->getPrice());
                $optionStock->setAgency($agency);
                $optionStock->setOptions($option);

                $entityManager->persist($optionStock);
                $entityManager->flush();

                // flash message
                $this->addFlash('success', 'Option stock created successfully!');
                return $this->redirectToRoute('app_option_stock_index', [], Response::HTTP_SEE_OTHER);
    
    
            }

            return $this->redirectToRoute('app_option_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('option_stock/new.html.twig', [
            'option_stock' => $optionStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_option_stock_show', methods: ['GET'])]
    public function show(OptionStock $optionStock): Response
    {
        return $this->render('option_stock/show.html.twig', [
            'option_stock' => $optionStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_option_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OptionStock $optionStock, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OptionStockType::class, $optionStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_option_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('option_stock/edit.html.twig', [
            'option_stock' => $optionStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_option_stock_delete', methods: ['POST'])]
    public function delete(Request $request, OptionStock $optionStock, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$optionStock->getId(), $request->request->get('_token'))) {
            $entityManager->remove($optionStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_option_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
