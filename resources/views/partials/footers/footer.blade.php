
<!-- Footer -->
<style>
    @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    footer {
        z-index: 1;
        //box-shadow: 0 -4px 18px 0px rgba(0, 0, 0, 0.12), 0 -7px 10px -5px rgba(0, 0, 0, 0.15);
    }

    section .section-title {
        text-align: center;
        color: #007b5e;
        margin-bottom: 50px;
        text-transform: uppercase;
    }
    #footer {
        background: #7a9aad !important;
    }
    #footer h5{
        padding-left: 10px;
        border-left: 3px solid #eeeeee;
        padding-bottom: 6px;
        margin-bottom: 20px;
        color:#ffffff;
    }
    #footer a {
        color: #ffffff;
        text-decoration: none !important;
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
    }
    #footer ul.social li{
        width: 50px;
        position: relative;
        padding: 3px 0;
    }


    #footer ul.social li a i {
        padding:5px;
        margin-right: 5px;
        font-size:35px;
        -webkit-transition: .25s all ease;
        -moz-transition: .25s all ease;
        transition: .25s all ease;
    }
    #footer ul.social li:hover a i {
        font-size: 30px;
        color: #7fcdee;
        margin-top:-10px;
    }
    #footer ul.social li a,
    #footer ul.quick-links li a{
        color:#ffffff;
    }
    #footer ul.social li a:hover{
        color:#eeeeee;
        margin-bottom: -3px;
    }
    #footer ul.quick-links li{
        padding: 3px 0;
        -webkit-transition: .5s all ease;
        -moz-transition: .5s all ease;
        transition: .5s all ease;
    }
    #footer ul.quick-links li:hover{
        padding: 3px 0;
        margin-left:5px;
        font-weight:700;
    }
    #footer ul.quick-links li a i{
        margin-right: 5px;
    }
    #footer ul.quick-links li:hover a i {
        font-weight: 700;
    }

    @media (max-width:767px){
        #footer h5 {
            padding-left: 0;
            border-left: transparent;
            padding-bottom: 0px;
            margin-bottom: 10px;
        }
    }
</style>
<footer id="footer" class="pt-1 pt-sm-3 pb-1 pb-sm-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img style="width: 100px;" src="{{ asset('images/logo_OP.png') }}" alt="">
            </div>
        <div class="row">
        </div>
    </div>
</footer>
<!-- ./Footer -->
