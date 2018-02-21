<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-5">
                    <div class="f-box">
                        <div id="googleMap"></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-7">
                    <div class="f-box">
                        <form class="f-contact" action="#">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Mobile">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Craft Type">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Comment"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-submit">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="f-box xs-table">
                        <ul class="list-info">
                            <li><span><i class="zmdi zmdi-email"></i></span>mail@mail.com</li>
                            <li><span><i class="zmdi zmdi-smartphone-iphone"></i></span>+965-333-333-333</li>
                            <li><span><i class="zmdi zmdi-pin"></i></span>Lorem ipsum dolor sit amet,<br> consectetur adipisicing elit, sed do</li>
                        </ul>
                        <ul class="f-social clearfix">
                            <li class="facebook">
                                <a href="#" target="_blank"><i class="zmdi zmdi-facebook"></i></a>
                            </li>
                            <li class="twitter">
                                <a href="#" target="_blank"><i class="zmdi zmdi-twitter"></i></a>
                            </li>
                            <li class="linkedin">
                                <a href="#" target="_blank"><i class="zmdi zmdi-linkedin"></i></a>
                            </li>
                            <li class="instagram">
                                <a href="#" target="_blank"><i class="zmdi zmdi-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="f-box xs-table">
                        <h2>Quick Links</h2>
                        <ul class="f-nav-menu">
                            <li><a href="#">website link</a></li>
                            <li><a href="#">website link</a></li>
                            <li><a href="#">website link</a></li>
                            <li><a href="#">website link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <p class="copy-right">Lorem ipsum dolor sit amet, consectetur</p>
                </div>
                <div class="col-sm-4">
                    <div class="me-payment">
                        <img src="{{url('front_end/images/payment.png')}}" alt="">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="f-delivery">
                        <div class="deliver-img"><img src="{{url('front_end/images/dev.png')}}" alt=""></div>
                        <p>Delivery to all  Kuwait cities</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript">
    

function format(e) {
    e.preventDefault();
    var name = document.getElementById('name').value
    var email = document.getElementById('email').value
    var mobile = document.getElementById('mobile').value
    var comment = document.getElementById('comment').value
    //alert(name);
  

            var url = '{{url("/en/contact")}}';
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'GET',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {name:name,email:email,mobile:mobile,comment:comment},
                success: function (response) {
                    console.log(response);
                    if(response){
                    document.getElementById('mess').style.display="block";
                    }
                },
                error: function (e) {
                    
                }
            });
        } 
</script>