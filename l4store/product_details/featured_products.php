<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//All Code and Design is copyrighted by Level Four Development, LLC

//Level Four Development, LLC provides this code "as is" without     

//warranty of any kind, either express or implied,       

//including but not limited to the implied warranties    

//of merchantability and/or fitness for a particular     

//purpose.         

//

//Only licnesed users may use this code and storfront for live purposes.

//All other use is prohibited and may be subject to copyright violation laws.

//If you have any questions regarding proper use of this code, please

//contact Level Four Development, LLC prior to use.

//

//All use of this storefront is subject to our terms of agreement found on

// Level Four Development, LLC's official website.

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//Version 8.1.0

?>

<?php if($row_productRS['featureproduct1'] != "0" || $row_productRS['featureproduct2'] != "0" || $row_productRS['featureproduct3'] != "0" || $row_productRS['featureproduct4'] != "0"){?>

<div class="floatleft">

    <div class="divider"></div>

    <div class="descriptiontitle">Customers Who Bought This Also Bought</div>

    <div class="divider"></div>

    <?php include("featured_1.php"); ?>

    <?php include("featured_2.php"); ?>

    <?php include("featured_3.php"); ?>

    <?php include("featured_4.php"); ?>

</div>

<?php }?>