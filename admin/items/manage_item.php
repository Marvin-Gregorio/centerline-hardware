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
                <label for="description" class="control-label">Description</label>
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
                        if($unit == 'BOX/S'){
                            echo '<option value="BOX/S" selected>BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
                        }
                        elseif($unit == 'PC/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S" selected>PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';   
                        }
                        elseif($unit == 'KG/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S" selected>KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
                        }
                        elseif($unit == 'SACK/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S" selected>SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
                        }
                        elseif($unit == 'GALLON/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S" selected>GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';  
                        }elseif($unit == 'BAG/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S" selected>BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
                        }else{
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S" selected>ROLL/S</option>';
                        } 
                    }else{
                        echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
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
                <label for="description" class="control-label">Description</label>
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
                        if($unit == 'BOX/S'){
                            echo '<option value="BOX/S" selected>BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
                        }
                        elseif($unit == 'PC/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S" selected>PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';   
                        }
                        elseif($unit == 'KG/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S" selected>KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
                        }
                        elseif($unit == 'SACK/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S" selected>SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
                        }
                        elseif($unit == 'GALLON/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S" selected>GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';  
                        }elseif($unit == 'BAG/S'){
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S" selected>BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
                        }else{
                            echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S" selected>ROLL/S</option>';
                        } 
                    }else{
                        echo '<option value="BOX/S">BOX/S</option>
                                    <option value="PC/S">PC/S</option>
                                    <option value="KG/S">KG/S</option>
                                    <option value="SACK/S">SACK/S</option>
                                    <option value="BAG/S">BAG/S</option>
                                    <option value="GALLON/S">GALLON/S</option>
                                    <option value="ROLL/S">ROLL/S</option>';
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