<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CuentaController extends AbstractController
{
    #[Route("/ticket/{mesa}/{pedido}/{iva}/{descuento}", name: "generar_ticket", requirements: ["mesa" => "[a-fA-F]\d{1,2}", "iva" => "\d{1,2}", "descuento" => "\d{1,3}"])]
    public function generarTicket(string $mesa, string $pedido, int $iva = 21, int $descuento = 0): Response
    {

        $producto = [];
        if (str_contains($pedido, '|')) {
            $productos = explode('|', $pedido);
            for ($i = 0; $i < count($productos); $i++) {
                $datos_producto = explode(',', $productos[$i]);
                $producto[$i] = ['concepto' => $datos_producto[0], 'cantidad' => $datos_producto[1], 'precio_ud' => $datos_producto[2]];
            }
        } else {
            $datos_producto = explode(',', $pedido);
            $producto[0] = ['concepto' => $datos_producto[0], 'cantidad' => $datos_producto[1], 'precio_ud' => $datos_producto[2]];
        }


        return $this->render('cuenta.html.twig',[
            'mesa' => $mesa,
            'pedido' => $producto,
            'iva' => $iva,
            'descuento' => $descuento
        ]);
    }
}