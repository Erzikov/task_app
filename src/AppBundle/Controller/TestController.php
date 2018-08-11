<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Port\Csv\CsvReader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $validator = $this->get("validator");


        $path = "/var/www/projects/task/app/Resources/csv/stock.csv";
        $file = new \SplFileObject($path);

        $reader = new CsvReader($file);
        $reader->setHeaderRowNumber(0);
        $reader->setStrict(false);
        $reader->setColumnHeaders(
            [
                "productCode",
                "productName",
                "productDescription",
                "stock",
                "costInUSA",
                "discontinued",
            ]
        );

        $test = $reader->getRow(2);

        $result = [];
//
//        foreach($reader as $row)
//        {
//            $product = new Product();
//            $result[] = $product->createFromArray($row);
//        }
//
//        $errorsItems = [];
//        $errorsMessage = [];
//
//        $totalSuccess = 0;
//        $totalErrors = 0;
//
//        foreach ($result as $row) {
//                $errors = $validator->validate($row);
//
//                if (count($errors) === 0 ){
//                    $totalSuccess++;
//                    $em->persist($row);
//                    $em->flush();
//                }else{
//                    $totalErrors++;
//                    $errorsItems[] = $row;
//                    $errorsMessage[] = $errors;
//                }
//        }
//
//        $total = [
//            "success" => $totalSuccess,
//            "errors" => $totalErrors,
//            "total" => $totalSuccess + $totalErrors,
//        ];


        return $this->render(
            'test/index.html.twig',
            [
                "test" => $test,
            ]
        );
    }
}
