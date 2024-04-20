<div class="navbar-header">
    <a href="home" class="navbar-brand"><b>Hiring</b>Portal</a>
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
    <i class="fa fa-bars"></i>
    </button>
</div>
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <ul class="nav navbar-nav">
       <li><a href="home" style="font-size: 17px;">Home</a></li>
       <li><a href="hiringnow" style="font-size: 17px;">Hiring Now</a></li>
       <li><a href="aboutus" style="font-size: 17px;">About Us</a></li>
       <li><a href="contactus" style="font-size: 17px;">Contact Us</a></li>
    </ul>
    <div class="navbar-form navbar-left" role="search">
       <div class="form-group">
          <input id="txtSearch" type="text" class="form-control cust-label" id="navbar-search-input" placeholder="Search Job Title Here">
       </div>
    </div>
</div>
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script type="application/x-javascript">
    $('#txtSearch').keyup(function (e) {
        if(e.keyCode == 13) {
            var url = "hiringnow?search=" + this.value;
            //alert(url);
            window.location.href = url;
        }
    });
</script>