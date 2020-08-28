<?php

if (!isset($_SESSION['CUSID'])) {
  redirect(web_root . "index.php");
}




$customerid = $_SESSION['CUSID'];
$customer = new Customer();
$singlecustomer = $customer->single_customer($customerid);

?>

<?php
$autonumber = new Autonumber();
$res = $autonumber->set_autonumber('ordernumber');
?>


<form onsubmit="return orderfilter()" action="customer/controller.php?action=processorder" method="post">
  <section id="cart_items">
    <div class="container">
      <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Order Details</li>
        </ol>
      </div>
      <div class="row">
        <div class="col-md-6 pull-left">
          <div class="col-md-2 col-lg-2 col-sm-2" style="float:left">
            Name:
          </div>
          <div class="col-md-8 col-lg-10 col-sm-3" style="float:left">
            <?php echo $singlecustomer->FNAME . ' ' . $singlecustomer->LNAME; ?>
          </div>
          <div class="col-md-2 col-lg-2 col-sm-2" style="float:left">
            Address:
          </div>
          <div class="col-md-8 col-lg-10 col-sm-3" style="float:left">
            <?php echo $singlecustomer->CUSHOMENUM . ' ' . $singlecustomer->STREETADD . ' ' . $singlecustomer->BRGYADD . ' ' . $singlecustomer->CITYADD . ' ' . $singlecustomer->PROVINCE . ' ' . $singlecustomer->COUNTRY; ?>
          </div>
        </div>

        <div class="col-md-6 pull-right">
          <div class="col-md-10 col-lg-12 col-sm-8">
            <input type="hidden" value="<?php echo $res->AUTO; ?>" id="ORDEREDNUM" name="ORDEREDNUM">
            Order Number :<?php echo $res->AUTO; ?>
          </div>
        </div>
      </div>
      <div class="table-responsive cart_info">

        <table class="table table-condensed" id="table">
          <thead>
            <tr class="cart_menu">
              <th style="width:12%; text-align:center;">Product</th>
              <th>Description</th>
              <th style="width:15%; align:center; ">Quantity</th>
              <th style="width:15%; align:center; ">Price</th>
              <th style="width:15%; align:center; ">Total</th>
            </tr>
          </thead>
          <tbody>

            <?php

            $tot = 0;
            if (!empty($_SESSION['gcCart'])) {
              $count_cart = @count($_SESSION['gcCart']);
              for ($i = 0; $i < $count_cart; $i++) {

                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                           WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  and p.PROID='" . $_SESSION['gcCart'][$i]['productid'] . "'";
                $mydb->setQuery($query);
                $cur = $mydb->loadResultList();
                foreach ($cur as $result) {
            ?>

                  <tr>
                    <!-- <td></td> -->
                    <td><img src="admin/products/<?php echo $result->IMAGES ?>" width="50px" height="50px"></td>
                    <td><?php echo $result->PRODESC; ?></td>
                    <td align="center"><?php echo $_SESSION['gcCart'][$i]['qty']; ?></td>
                    <td>&#x20B9 <?php echo  $result->PRODISPRICE ?></td>
                    <td>&#x20B9 <output><?php echo $_SESSION['gcCart'][$i]['price'] ?></output></td>
                  </tr>
            <?php
                  $tot += $_SESSION['gcCart'][$i]['price'];
                }
              }
            }
            ?>


          </tbody>

        </table>
        <div class="  pull-right">
          <p align="right">
            <div> Total Price : &#x20B9 <span id="sum">0.00</span></div>
            <div> Delivery Fee : &#x20B9 <span id="fee">0.00</span></div>
            <div> Overall Price : &#x20B9 <span id="overall"><?php echo $tot; ?></span></div>
            <input type="hidden" name="alltot" id="alltot" value="<?php echo $tot; ?>" />
          </p>
        </div>

      </div>
    </div>
  </section>

  <section id="do_action">
    <div class="container">
      <div class="heading">
        <h3>What would you like to do next?</h3>
        <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
      </div>
      <div class="row">
        <div class="row">
          <div class="col-md-7">
            <div class="form-group">
              <label> Payment Method : </label>
              <div class="radio">
                <label>
                  <input type="radio" class="paymethod" name="paymethod" id="deliveryfee" value="Cash on Delivery" checked="true" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne">Cash on Delivery

                </label>
              </div>
            </div>
            <div class="radio">
              <label>
                <style>
                  .collapsible {
                    background-color: transparent;
                    color: #000000;
                    cursor: pointer;
                    /*padding: 18px;*/
                    /*width: 100%;*/
                    border: none;
                    text-align: left;
                    outline: none;
                    font-size: 15px;
                  }

                  .active,
                  .collapsible:hover {
                    background-color: #ffffff;
                  }

                  .content {
                    padding: 0 18px;
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height 0.2s ease-out;
                    background-color: #ffffff;
                  }

                  .content .form {
                    width: 100%;
                  }

                  .content .form .input_field {
                    margin-bottom: 15px;
                    display: flex;
                    align-items: center;
                  }

                  .content .form .input_field label {
                    width: 200px;
                    color: #757575;
                    margin-right: 10px;
                    font-size: 14px;
                  }

                  .content .form .input_field .input {
                    width: 100%;
                    outline: none;
                    border: 1px solid #d5dbd9;
                    font-size: 15px;
                    padding: 8px 10px;
                    border-radius: 3px;
                    transition: all 0.3s ease;
                  }
                </style>
                <input type="radio" class="paymethod" name="paymethod" id="deliveryfee" value="Card" checked="true" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne"><span class="collapsible">
                  Debit/Credit Card
                </span>
                <div class="content">
                  <div class="form">
                    <div class="input_field">
                      <label>Name On Card</label>
                      <input type="text" class="input" name="nCard">
                    </div>
                    <div class="input_field">
                      <label>Card No</label>
                      <input type="text" class="input" name="noCard">
                    </div>
                    <div class="input_field">
                      <label>Expiration (MM/YY)</label>
                      <input type="text" class="input" name="expire">
                    </div>
                    <div class="input_field">
                      <label>CVV</label>
                      <input type="text" class="input" name="cvv">
                    </div>
                  </div>
                </div>


              </label>
            </div>
            <div class="radio">
              <label>
                <style>
                  .collapsible {
                    background-color: transparent;
                    color: #000000;
                    cursor: pointer;
                    /*padding: 18px;*/
                    /*width: 100%;*/
                    border: none;
                    text-align: left;
                    outline: none;
                    font-size: 15px;
                  }

                  .active,
                  .collapsible:hover {
                    background-color: #ffffff;
                  }

                  .content {
                    padding: 0 18px;
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height 0.2s ease-out;
                    background-color: #ffffff;
                  }

                  .content .form {
                    width: 100%;
                  }

                  .content .form .input_field {
                    margin-bottom: 15px;
                    display: flex;
                    align-items: center;
                  }

                  .content .form .input_field label {
                    width: 200px;
                    color: #757575;
                    margin-right: 10px;
                    font-size: 14px;
                  }

                  .content .form .input_field .input {
                    width: 100%;
                    outline: none;
                    border: 1px solid #d5dbd9;
                    font-size: 15px;
                    padding: 8px 10px;
                    border-radius: 3px;
                    transition: all 0.3s ease;
                  }
                </style>
                <input type="radio" class="paymethod" name="paymethod" id="deliveryfee" value="UPI" checked="true" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne"><span class="collapsible">
                  UPI Transaction
                </span>
                <div class="content">
                  <div class="form">
                    <div class="input_field">
                      <label>UPI ID</label>
                      <input type="text" class="input" name="nupi">
                    </div>
                  </div>
                </div>

                <script>
                  var coll = document.getElementsByClassName("collapsible");
                  var i;

                  for (i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function() {
                      this.classList.toggle("active");
                      var content = this.nextElementSibling;
                      if (content.style.maxHeight) {
                        content.style.maxHeight = null;
                      } else {
                        content.style.maxHeight = content.scrollHeight + "px";
                      }
                    });
                  }
                </script>

              </label>
            </div>
          </div>
        </div>
        <div class="panel">
          <div class="panel-body">
            <div class="form-group ">
              <label>Address where to deliver</label>


              <div class="col-md-12">
                <label class="col-md-4 control-label" for="PLACE">Place(City):</label>

                <div class="col-md-8">
                  <select class="form-control paymethod" name="PLACE" id="PLACE" onchange="validatedate()">
                    <option value="0">Select</option>
                    <?php
                    $query = "SELECT * FROM `tblsetting` ";
                    $mydb->setQuery($query);
                    $cur = $mydb->loadResultList();

                    foreach ($cur as $result) {
                      echo '<option value=' . $result->DELPRICE . '>' . $result->BRGY . ' ' . $result->PLACE . ' </option>';
                    }
                    ?>
                  </select>
                </div>
              </div>

            </div>

          </div>
        </div>

        <input type="hidden" placeholder="HH-MM-AM/PM" id="CLAIMEDDATE" name="CLAIMEDDATE" value="<?php echo date('y-m-d h:i:s') ?>" class="form-control" />

      </div>



    </div>
    <br />
    <div class="row">
      <div class="col-md-6">
        <a href="index.php?q=cart" class="btn btn-default pull-left"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;<strong>View Cart</strong></a>
      </div>
      <div class="col-md-6">
        <button type="submit" class="btn btn-pup  pull-right " name="btn" id="btn" onclick="return validatedate();" /> Submit Order <span class="glyphicon glyphicon-chevron-right"></span></button>
      </div>
    </div>

    </div>
    </div>
  </section>
  <!--/#do_action-->
</form>