<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `item_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}
?>
<style>
    span.select2-selection.select2-selection--single {
        border-radius: 0;
        padding: 0.25rem 0.5rem;
        padding-top: 0.25rem;
        padding-right: 0.5rem;
        padding-bottom: 0.25rem;
        padding-left: 0.5rem;
        height: auto;
    }
</style>
<?php if(isset($_GET['purpose'])){ ?>
    <form action="" id="restock-form">
        <input type="hidden" name="restock">
         <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="container-fluid">
            <div class="form-group">
                <label for="name" class="control-label">Item Code</label>
                <input type="text" name="name" id="name" class="form-control rounded-0" value="<?php echo isset($name) ? $name :"" ?>" required>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Item Name</label>
                <textarea rows="3" name="description" id="description" class="form-control rounded-0" required><?php echo isset($description) ? $description :"" ?></textarea>
            </div>
            <div class="form-group">
                <label for="price" class="control-label">Price</label>
                <input type="int" name="price" id="price" class="form-control rounded-0" value="<?php echo isset($price) ? $price :"" ?>" required>
            </div>
            <div class="form-group">
                <label for="stock" class="control-label">Qty/Stocks</label>
                <input type="int" name="stock" id="stock" class="form-control rounded-0" value="" required>
            </div>
            <div class="form-group">
                <label for="unit" class="control-label">Unit/Measure</label>
                <select name="unit" class="form-control rounded-0" name="unit">
                    <?php 
                    if(isset($unit)){
                        if($unit == 'BOX'){
                            echo '<option value="BOX" selected>BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                        }
                        elseif($unit == 'PC'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC" selected>PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';   
                        }
                        elseif($unit == 'KG'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG" selected>KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                        }
                        elseif($unit == 'SACK'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK" selected>SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                        }
                        elseif($unit == 'GALLON'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON" selected>GALLON</option>
                                    <option value="ROLL">ROLL</option>';  
                        }elseif($unit == 'BAG'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG" selected>BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                        }else{
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL" selected>ROLL</option>';
                        } 
                    }else{
                        echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="location" class="control-label">Location</label>
                <select name="location" class="form-control rounded-0">
                    <?php 
                        $supplier_qry = $conn->query("SELECT * FROM `supplier_list` order by `name` asc");
                        while($row = $supplier_qry->fetch_assoc()){
                            if($location == $row['id']){
                                echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
                            }else{
                                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                            }
                            
                        }
                    ?>
                </select>
            </div>
            <!--<div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="form-control rounded-0" required>
                    <option value="1" <?php echo isset($status) && $status =="" ? "selected": "1" ?> >Active</option>
                    <option value="0" <?php echo isset($status) && $status =="" ? "selected": "0" ?>>Inactive</option>
                </select>
            </div>-->
        </div>
    </form>
<?php }else{?>
    <form action="" id="item-form">
         <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="container-fluid">
            <div class="form-group">
                <label for="name" class="control-label">Item Code</label>
                <input type="text" name="name" id="name" class="form-control rounded-0" value="<?php echo isset($name) ? $name :"" ?>" required>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Item Name</label>
                <textarea rows="3" name="description" id="description" class="form-control rounded-0" required><?php echo isset($description) ? $description :"" ?></textarea>
            </div>
            <div class="form-group">
                <label for="price" class="control-label">Price</label>
                <input type="int" name="price" id="price" class="form-control rounded-0" value="<?php echo isset($price) ? $price :"" ?>" required>
            </div>
            <div class="form-group">
                <label for="stock" class="control-label">Qty/Stocks</label>
                <input type="int" name="stock" id="stock" class="form-control rounded-0" value="<?php echo isset($stock) ? $stock :"" ?>" required>
            </div>
            <div class="form-group">
                <label for="unit" class="control-label">Unit/Measure</label>
                <select name="unit" class="form-control rounded-0" name="unit">
                    <?php 
                    if(isset($unit)){
                        if($unit == 'BOX'){
                            echo '<option value="BOX" selected>BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                        }
                        elseif($unit == 'PC'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC" selected>PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';   
                        }
                        elseif($unit == 'KG'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG" selected>KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                        }
                        elseif($unit == 'SACK'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK" selected>SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                        }
                        elseif($unit == 'GALLON'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON" selected>GALLON</option>
                                    <option value="ROLL">ROLL</option>';  
                        }elseif($unit == 'BAG'){
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG" selected>BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                        }else{
                            echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL" selected>ROLL</option>';
                        } 
                    }else{
                        echo '<option value="BOX">BOX</option>
                                    <option value="PC">PC</option>
                                    <option value="KG">KG</option>
                                    <option value="SACK">SACK</option>
                                    <option value="BAG">BAG</option>
                                    <option value="GALLON">GALLON</option>
                                    <option value="ROLL">ROLL</option>';
                    }
                    ?>
                        
                    
                </select>
            </div>
            <div class="form-group">
                <label for="location" class="control-label">Location</label>
                <select name="location" class="form-control rounded-0">
                    <?php 
                        $supplier_qry = $conn->query("SELECT * FROM `supplier_list` order by `name` asc");
                        while($row = $supplier_qry->fetch_assoc()){
                            if($location == $row['id']){
                                echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
                            }else{
                                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                            }
                            
                        }
                    ?>
                </select>
            </div>
            <!--<div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="form-control rounded-0" required>
                    <option value="1" <?php echo isset($status) && $status =="" ? "selected": "1" ?> >Active</option>
                    <option value="0" <?php echo isset($status) && $status =="" ? "selected": "0" ?>>Inactive</option>
                </select>
            </div>-->
        </div>
    </form>
<?php } ?>
<script>
    $(function(){
        $('#item-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_item",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload();
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
                    end_loader()
				}
			})
		})
	})

    $(function(){
        $('#restock-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
             $('.err-msg').remove();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_item",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp =='object' && resp.status == 'success'){
                        location.reload();
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                    }else{
                        alert_toast("An error occured",'error');
                        console.log(resp)
                    }
                    end_loader()
                }
            })
        })
    })
</script>