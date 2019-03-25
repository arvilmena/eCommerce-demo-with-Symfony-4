<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/web", name="web_home")
     */
    public function index()
    {

        $products = array(
            array(
                'name' => 'Google Pixel - Black',
                'price' => '10',
                'image' => 'product-1.png',
                'description' => 'Spicy jalapeno bacon ipsum dolor amet kielbasa sausage ham hock jerky tenderloin, venison pork belly turducken. Tail landjaeger pork loin, kevin turkey shoulder andouille t-bone ground round tongue shankle pancetta ham boudin ham hock. Bacon cupim t-bone filet mignon shoulder, bresaola beef ribs capicola chuck. Tail jowl pancetta beef bresaola, tongue turducken cupim ham hock buffalo pork chop pork belly meatball short ribs.',
            ),
            array(
                'name' => 'Samsung S7',
                'price' => '16',
                'image' => 'product-2.png',
                'description' => 'Corned beef prosciutto tail capicola ribeye flank pork beef ribs sausage pastrami tenderloin ham. Chuck pork ham hock short loin turkey ground round tri-tip tongue cupim porchetta biltong landjaeger boudin shank jerky. Shankle pork chop doner frankfurter short loin buffalo brisket cupim tongue. Leberkas shankle pork, andouille hamburger shank sirloin bacon swine. Meatloaf ham tongue, beef beef ribs chicken cow tenderloin short loin shankle. Meatball kielbasa flank pork strip steak turkey t-bone corned beef ground round pork chop alcatra. Short loin venison leberkas ground round doner ribeye.',
            ),
            array(
                'name' => 'HTC 10 - Black',
                'price' => '8',
                'image' => 'product-3.png',
                'description' => 'Chicken pork belly venison tail cow prosciutto ribeye hamburger sausage. Pancetta alcatra beef prosciutto pork chop t-bone, pig ground round bresaola pork loin strip steak salami andouille. Landjaeger cupim short loin, swine cow pork belly pork ham buffalo strip steak t-bone pork chop. Ground round biltong kevin, chicken turkey tail prosciutto tri-tip pastrami cupim tongue kielbasa rump.',
            ),
            array(
                'name' => 'HTC 10 - White',
                'price' => '10',
                'image' => 'product-4.png',
                'description' => 'Meatloaf pastrami corned beef fatback short ribs swine. Drumstick pig picanha, ham hock tenderloin alcatra ball tip. Ball tip frankfurter t-bone sausage. Capicola pork belly leberkas venison cow, picanha cupim swine buffalo shank meatball strip steak kielbasa tail frankfurter.',
            ),
            array(
                'name' => 'HTC Desire 626s',
                'price' => '24',
                'image' => 'product-5.png',
                'description' => 'Cow sirloin tri-tip, ham hock shankle ribeye ham sausage brisket pork tenderloin. Bresaola shoulder pork, prosciutto kevin ham tongue pastrami. Sirloin beef ham hock salami jowl hamburger brisket rump short ribs porchetta cow venison short loin beef ribs. Bacon buffalo rump picanha turducken. Tail bresaola ham boudin. Chuck ball tip kielbasa cow pork loin hamburger.',
            ),
            array(
                'name' => 'Vintage Iphone',
                'price' => '17',
                'image' => 'product-6.png',
                'description' => 'Meatball ground round shankle spare ribs venison swine turkey beef ribs filet mignon burgdoggen jowl ham hock. Bresaola landjaeger corned beef, shoulder chicken pork loin andouille meatball beef doner tail porchetta meatloaf boudin. Tri-tip kielbasa ground round turducken shank cupim alcatra. Pastrami kielbasa jowl beef, ground round cow sausage turducken doner filet mignon jerky. Capicola strip steak salami ground round.',
            ),
            array(
                'name' => 'Iphone 7',
                'price' => '30',
                'image' => 'product-7.png',
                'description' => 'Pig short loin frankfurter shoulder pork. Beef shankle turducken, shank landjaeger venison pig tail rump picanha bresaola porchetta. Flank shank kevin meatloaf. Doner short loin chuck landjaeger kevin, tenderloin kielbasa salami meatball ball tip chicken porchetta bresaola.',
            ),
            array(
                'name' => 'Smashed Iphone',
                'price' => '2',
                'image' => 'product-8.png',
                'description' => 'Rump doner sausage salami cupim. Kielbasa brisket pancetta ribeye hamburger ground round. Beef ribs picanha biltong bacon. Turkey capicola flank, brisket venison bacon turducken chuck pork loin buffalo drumstick cupim meatball alcatra spare ribs. Strip steak beef prosciutto landjaeger, fatback chuck swine ham hock meatloaf shankle flank shoulder ball tip spare ribs. Shank jowl short loin, ball tip leberkas meatball doner cow short ribs bacon.',
            ),
        );

        return $this->render('web/default/home.html.twig', [
            'products' => $products,
        ]);
    }
}
