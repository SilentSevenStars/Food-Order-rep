<div class="row">
                        <?php
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $paginationData = $showOrder->showRecordsWithPagination($currentPage, null,3, "id DESC");
                            $orders = $paginationData['records'];
                            if(count($orders) > 0){
                                foreach ($orders as $order) {
                                    $carts = $showCart->showRecords("id = $order[1]");
                                    if(count($carts) > 0){
                                        $customer = $showCustomer->showRecords("id = ".$carts[0][1]);
                                        if(count($customer) > 0){
                        ?>
                        <div class="card card-1">
                            <div class="card-header">
                                <div class="media flex-sm-row flex-column-reverse justify-content-between">
                                    <div class="col my-auto">
                                        <h4 class="mb-0">Order<span class="change-color">#<?= $order[0] ?></span></h4>
                                        <h4 class='mb-0'>Name: <?= $customer[0][1] ?></h4>
                                        <h4 class='mb-0'>Phone Number: <?= $customer[0][3] ?></h4>
                                        <h4 class='mb-0'>Email: <?= $customer[0][2] ?></h4>
                                        <h4 class='mb-0'>Address: <?= $customer[0][4] ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-between mb-3">
                                    <div class="col-auto">
                                        <h6 class="color-1 mb-0 change-color">Receipt</h6>
                                    </div>
                                </div>
                                <?php
                                    $lists = $showList->showRecords("cart_id = ".$carts[0][0]);
                                    if(count($lists) > 0){
                                        foreach ($lists as $list) { 
                                            $product = $showProduct->showRecords("id = $list[1]");
                                ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="card card-2">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="sq align-self-center">
                                                        <img class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="../upload_img/<?= $product[0][4] ?>" width="135" height="135" />
                                                    </div>
                                                    <div class="media-body my-auto text-right">
                                                        <div class="row  my-auto flex-column flex-md-row">
                                                            <div class="col my-auto">
                                                                <h6 class="mb-0"><?= $product[0][1] ?></h6>
                                                            </div>
                                                            <div class="col my-auto">
                                                                <p style="font-size: 20px;">Price per item : <?= $product[0][3] ?></p>
                                                            </div>
                                                            <div class="col my-auto">
                                                                <p style="font-size: 20px;">Quantity : <?= $list[2] ?></p>
                                                            </div>
                                                            <div class="col my-auto">
                                                                <h6 class="mb-0" style="font-size: 20px;">&#8369;<?= $list[3] ?></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                            <hr class="my-3 ">
                            <div class="row">
                                <div class="mb-3">
                                    <h4>Total Amount: &#8369;<?= $order[3] ?></h4>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Payment status</label>
                                    <select name="" id="" class="form-select">
                                        <?php
                                            echo "<option value='".$order[5]."' selected>".$order[5]."</option>";
                                            if($order[5] === 'Ongoing')
                                                echo "<option value='Complete'>Complete</option>";
                                            else 
                                                echo "<option value='Ongoing'>Ongoing</option>";
                                        ?>
                                    </select>
                                </div>
                                <div class="col mt-auto">
                                    <div>
                                        
                                    </div>
                                    <div class="media row justify-content-between ">
                                        <div class="col-auto text-right">
                                            <span><small class="text-right mr-sm-2"></small></span>
                                        </div>
                                        <div class="flex-col">
                                            <span><small class="text-right mr-sm-2">Out for delivery</small></span>
                                        </div>
                                        <div class="col-auto flex-col-auto">
                                            <small class="text-right mr-sm-2">Delivered</small><span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                            } else {
                                                echo "This customer doesn't exist";
                                            }
                                        } else {
                                            echo "This order has been deleted";
                                        }
                                    }
                                } else {
                                    echo "<div class='alert alert-danger text-center fs-3 fw-semibold'>No order</div>";
                                }
                        ?>
                    </div>
                    <?php
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $paginationData = $showOrder->showRecordsWithPagination($currentPage, null,3, "id DESC");
                        $orders = $paginationData['records'];
                        if(count($orders) > 0){
                    ?>
                    <nav class="d-flex justify-content-center" aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?=($currentPage - 1)?>">Previous</a>
                            </li>
                            <?php endif; ?>
                            <?php for ($page = 1; $page <= $paginationData['totalPages']; $page++): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?=$page?>"><?=$page?></a></li>
                            <?php endfor; ?>
                            <?php if ($currentPage < $paginationData['totalPages']): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?=($currentPage + 1)?>">Next</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php
                        }
                    ?>