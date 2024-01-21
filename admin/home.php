<h3 class="text-dark">Dashboard</h3>
<hr class="border-dark">
<div class="row">
          <div class="col-24 col-sm-12 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-4">!</span>
              <a class="info-box-content" style="text-decoration:none; color:inherit;" href="<?php echo base_url ?>admin/?page=items&stock=20" id="restock_btn">
                <span class="info-box-text " STYLE= "font-weight:bold">Restock Item NEEDED</span>
                <span class="info-box-number" id="restock_item">
                  <?php 
                     $po = $conn->query("SELECT * FROM item_list where `stock` < 20 ")->num_rows;
                     echo number_format($po);
                     if($po > 0){
                      echo '<script>
                        Swal.fire({
                          title: "Re-Stock",
                          text: "You need to restock!",
                          icon: "warning"
                        }).then((result)=>{
                          if(result.isConfirmed)
                            document.getElementById("restock_btn").click();
                        });
                      </script>';
                     }
                  ?>
                </span>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-24 col-sm-12 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-red elevation-4"><i class="fas fa-truck-loading"></i></span>

              <a class="info-box-content" style="text-decoration:none; color:inherit;" href="<?php echo base_url ?>admin/?page=purchase_orders">
                <span class="info-box-text" STYLE= "font-weight:bold">Sales</span>
                <span class="info-box-number">
                  <?php 
                    $sales = $conn->query("SELECT * FROM po_list")->num_rows;
                    echo number_format($sales);
                  ?>
                  <?php ?>
                </span>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-24 col-sm-12 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-4"><i class="fas fa-boxes"></i></span>

              <a class="info-box-content" style="text-decoration:none; color:inherit;" href="<?php echo base_url ?>admin/?page=items">
                <span class="info-box-text" STYLE= "font-weight:bold">Total Items</span>
                <span class="info-box-number">
                  <?php 
                     $item = $conn->query("SELECT * FROM item_list")->num_rows;
                     echo number_format($item);
                  ?>
                </span>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
           <!-- /.col -->
           <div class="col-24 col-sm-12 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-4"><i class="fa fa-check"></i></span>

              <a class="info-box-content" style="text-decoration:none; color:inherit;" href="<?php echo base_url ?>admin/?page=purchase_orders&status=1">
                <span class="info-box-text" STYLE= "font-weight:bold">Approve P.O.</span>
                <span class="info-box-number">
                  <?php 
                     $po_appoved = $conn->query("SELECT * FROM po_list where `status` =1 ")->num_rows;
                     echo number_format($po_appoved);
                  ?>
                  
                </span>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-24 col-sm-12 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-4"><i class="fa fa-ban"></i></span>
              <a class="info-box-content" style="text-decoration:none; color:inherit;" href="<?php echo base_url ?>admin/?page=purchase_orders&status=2">
                <span class="info-box-text " STYLE= "font-weight:bold">Cancel PO</span>
                <span class="info-box-number">
                  <?php 
                     $po = $conn->query("SELECT * FROM po_list where `status` =2 ")->num_rows;
                     echo number_format($po);
                  ?>
                </span>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-24 col-sm-12 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-4"><i class="fa fa-clipboard-list"></i></span>
              <a class="info-box-content" style="text-decoration:none; color:inherit;" href="<?php echo base_url ?>admin/?page=purchase_orders&status=0">
                <span class="info-box-text " STYLE= "font-weight:bold">PENDING PO</span>
                <span class="info-box-number">
                  <?php 
                     $po = $conn->query("SELECT * FROM po_list where `status` =0 ")->num_rows;
                     echo number_format($po);
                  ?>
                </span>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <?php 
            $supplier_qry = $conn->query("SELECT * FROM `supplier_list` order by `name` asc");
            while($row = $supplier_qry->fetch_assoc()){
              echo '<div class="col-24 col-sm-12 col-md-6">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-info elevation-4"><i class="fa fa-shopping-cart"></i></span>
                  <a class="info-box-content" style="text-decoration:none; color:inherit;" href="'. base_url.'admin/?page=items&location='.$row['id'].'">
                    <span class="info-box-text " STYLE= "font-weight:bold">'.$row['name'].'</span>
                    <span class="info-box-number">';
                     $loc_home_id = $row['id'];
                     $po = $conn->query("SELECT * FROM item_list where `location` = '$loc_home_id' ")->num_rows;
                     echo number_format($po);

                    echo '</span>
                  </a>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>';
            }
          ?>

          <!-- /.col -->
        </div>
<div class="container">
  
</div>
<script>
      let id = $('#restock_item').val();
      if( id != 0){
        Swal.fire({
          icon: "warning",
          title: "Oops...",
          text: "You need to Restock!"
        }).then(()=>{
          document.getElementById('restock_btn').click();
        });
      }
</script>
