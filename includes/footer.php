<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-left">
        <div class="row text-center text-md-left">
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Foodies</h5>
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Categories</h5>
                <ul>
                    <?php
                        $cats = $showCategory->showRecords();
                        if(count($cats) > 0){
                            foreach ($cats as $cat) {
                                echo "<li style='list-style: none;'>
                                        <a href='index.php?cat_id=".$cat[0]."' class='text-white' style='text-decoration: none;'>".$cat[1]."</a>
                                    </li>";
                            }
                        } else {
                            echo "";
                        }
                    ?>
                </ul>
            </div>
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Social Links</h5>
                <p>
                    <a href="" class="text-white" style="text-decoration: none;"><i class="bi bi-facebook"></i></a>
                    <a href="" class="text-white" style="text-decoration: none;"><i class="bi bi-twitter-x"></i></a>
                    <a href="" class="text-white" style="text-decoration: none;"><i class="bi bi-youtube"></i></a>
                </p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-4 mx-auto-3 mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Contact</h5>
                
                <p>
                    <a href="" class="text-white" style="text-decoration: none;"></a>
                </p>
                <p>
                    <a href="" class="text-white" style="text-decoration: none;"></a>
                </p>
                <p>
                    <a href="" class="text-white" style="text-decoration: none;"></a>
                </p>
                <p>
                    <a href="" class="text-white" style="text-decoration: none;"></a>
                </p>
            </div>
        </div>
        <hr class="mb-4">
        <div class="row alight-items-center">
            <div class="col">
                <p>Copyright @2024 All rights reserved by: Foodies</p>
            </div>
        </div>
    </div>
</footer>