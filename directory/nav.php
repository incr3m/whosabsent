<!-- <div id="banner"> 
<a href="?home" ><img src='resources/logo1.png' style="height:200px;margin-left:40px"/></a>
<h1 >Face Recognition and Attendance System</h1>
</div>
 <div>
      <div class="columns">
      	<div class="btn-group" style='color:white;float:right;width:200px;cursor:pointer'>
            <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height:55px;width:200px;text-align:right;padding-right:20px;padding-top:10px">
            <div style="float:right;margin-left:10px"><span class="caret"></span></div>
              <div style="float:right;margin-left:10px"><div style="font-weight:bold"><?php $curUser = getCurrentUser(); echo $curUser['name'];?></div>
              <div style="font-size:smaller">
              <?php echo getCurrentUserType();?> </div></div>
            </div>
            <ul class="dropdown-menu pull-right">
              <li><a href="?module=acct&id=<?php echo $curUser['idno']; ?>&">My Account</a></li>
              <li role="separator" class="divider"></li>
              <li><a id="logoutBtn">Log out</a></li>
            </ul>
          </div>
           <script>
              $(document).on("click", "#logoutBtn", function(e) {
                  bootbox.confirm("Are you sure?", function(result) {
                    if(result){
                      window.location = 'login/logout.php';
                    }
                  }); 
              });
          </script>
        <nav style="height:50px">
        
          <ul>
            <li><a href="?home">Home</a></li>
            <li><a href="?about">About Us</a></li>
            
          </ul>
          <!-- Single button -->
          
          </nav>

      </div> 

    </div> -->

 