<?php
session_start();
include('codes/includes/dbconnection.php');

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mobnum = $_POST['phone'];
    $email = $_POST['email'];
    $appdate = $_POST['date'];
    $apptime = $_POST['time'];
    $specialization = $_POST['specialization'];
    $message = $_POST['message'];
    $aptnumber = mt_rand(100000000, 999999999);
    $cdate = date('Y-m-d');

    if($appdate <= $cdate) {
        echo '<script>alert("Appointment date must be greater than today\'s date")</script>';
    } else {
        $formattedTime = date('H:i:s', strtotime($apptime));

        $sqlCheckDuplicate = "SELECT * FROM tblappointment WHERE AppointmentDate = :appdate AND AppointmentTime = :apptime";
        $stmtCheckDuplicate = $dbh->prepare($sqlCheckDuplicate);
        $stmtCheckDuplicate->bindParam(':appdate', $appdate, PDO::PARAM_STR);
        $stmtCheckDuplicate->bindParam(':apptime', $formattedTime, PDO::PARAM_STR);
        $stmtCheckDuplicate->execute();

        if ($stmtCheckDuplicate->rowCount() > 0) {
            echo '<script>
                    alert("Time selected for the date is currently occupied. Please select another time for the date");
                 </script>';
        } else {
            $sqlInsert = "INSERT INTO tblappointment (AppointmentNumber, Name, MobileNumber, Email, AppointmentDate, AppointmentTime, Specialization, Message) VALUES (:aptnumber, :name, :mobnum, :email, :appdate, :apptime, :specialization, :message)";
            $query = $dbh->prepare($sqlInsert);
            $query->bindParam(':aptnumber', $aptnumber, PDO::PARAM_STR);
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':mobnum', $mobnum, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':appdate', $appdate, PDO::PARAM_STR);
            $query->bindParam(':apptime', $formattedTime, PDO::PARAM_STR);
            $query->bindParam(':specialization', $specialization, PDO::PARAM_STR);
            $query->bindParam(':message', $message, PDO::PARAM_STR);

            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId > 0) {
                echo '<script>
                        alert("Your Appointment Request Has Been Sent. We Will Contact You Soon");
                        // Trigger your modal display code here
                      </script>';
                echo "<script>window.location.href ='index.php'</script>";
            } else {
                echo '<script>alert("Something Went Wrong. Please try again")</script>';
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Halipa</title>
        <!-- CSS FILES -->        
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/owl.carousel.min.css" rel="stylesheet">

        <link href="css/owl.theme.default.min.css" rel="stylesheet">

        <link href="css/templatemo-medic-care.css" rel="stylesheet">

        <link rel="stylesheet" href="style1.css">
        <script>
function getdoctors(val) {
  //  alert(val);
$.ajax({

type: "POST",
url: "dentist.php",
data:'sp_id='+val,
success: function(data){
$("#doctorlist").html(data);
}
});
}
</script>
    </head>
    
    <body id="top">
    
        <main>

            <?php include_once('includes/header.php');?>

<!-- Home section start-->
<section class="home" id="home">

    <div class="container">
 
       <div class="row min-vh-100 align-items-center">
          <div class="content text-center text-md-left">
             <h3>Seeing your patient smile is one of the greatest happiness a dentist can have.</h3>
          </div>
       </div>
 
    </div>
 
 </section>
<!-- Home section end -->
                       

<!-- About section start -->
<section class="about" id="about">

    <div class="container">
 
       <div class="row align-items-center">
 
          <div class="col-md-6 image">
             <img src="images/halipa1.jpg" class="w-100 mb-5 mb-md-0" alt="image here">
          </div>
 
          <div class="col-md-6 content">
             <span>about us</span>
             <h3>A confident smile is a winning smile!</h3>
             <p>Halipa Dental Clinic, located in Panabo, is a dental clinic specializing in providing comprehensive dental care services. 
               With a team of experienced dentists, the clinic offers a range of treatments and procedures to address various dental needs. 
               Whether it's routine check-ups, dental cleanings, or more advanced procedures, Halipa Dental Clinic aims to deliver high-quality 
               and personalized care to its patients. For more information about the clinic and its services.</p>
          </div>
 
       </div>
 
    </div>
 
 </section>
<!-- About section end-->
<!-- services section start  -->
<section class="services" id="services">

    <h1 class="heading">Services</h1>
    <div class="box-container container">
    <?php
    $sql = "SELECT servicename, description, price FROM services";
    $query = $dbh->prepare($sql);
    $query->execute();
    $services = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($services as $service) {
    ?>
        <div class="box">
            <?php
            ?>
            <img src="images/<?php echo strtolower(str_replace(' ', '', $service['servicename'])); ?>.png" alt="">
            <h3><?php echo htmlentities($service['servicename']); ?></h3>
            <!-- <p>Price: ₱<?php echo number_format($service['price'], 2); ?></p> -->
            <p><?php echo htmlentities($service['description']); ?></p>
        </div>
    <?php
    }
    ?>
</div>


    <!-- <div class="box-container container">
 
       <div class="box">
          <img src="images/Periodontics.png" alt="">
          <h3>Periodontics</h3>
          <p>We mean it when we say we are your complete dental care shop. Here, gums are as important as the teeth. 
            Our periodontic treatments are comprehensive, with our specialized dentists providing patients with the best procedures and solutions, 
            effective medication and guidelines, and thorough follow-ups.</p>
       </div>
 
       <div class="box">
          <img src="images/surgery.png" alt="">
          <h3>Surgery</h3>
          <p>You can expect our team of dentists to be very gentle but thorough with every surgical process. From simple extractions to complex treatments like frenectomy, 
            where tissue is removed to prepare for dentures or braces, patients can be assured of great comfort during surgery and long-term enhancement of oral functions.</p>
       </div>
 
       <div class="box">
          <img src="images/Endodontics.png" alt="">
          <h3>Endodontics</h3>
          <p>Root canal therapy at Dental World is painless and even relaxing. After gaining access to the tooth through our modern rotary RCT machines, 
            all the canals are cleaned out thoroughly with special antiseptics. The void created is filled entirely with plasticized material that renders the whole canal system inert,
             stable, and pain-free.</p>
       </div>
 
       <div class="box">
          <img src="images/Restorative.png" alt="">
          <h3>Restorative</h3>
          <p>With a single session of tooth bonding, you can have an improved smile and even eliminate the need for more rigorous orthodontic treatment. 
            This procedure makes your smile more symmetrical and space-free via composite fillings or inlay and onlay restorations for large cavities.</p>
       </div>
 
       <div class="box">
          <img src="images/Orthodontics.png" alt="">
          <h3>Orthodontics</h3>
          <p>We are proud to offer Invisalign Braces apart from metal and ceramic brackets. Invisalign uses a series of clear aligners that are custom-molded for each patient. 
            The virtually invisible aligners gradually reposition your teeth into a smile you’ll be proud of. 
            </p>
       </div>
 
       <div class="box">
          <img src="images/Prosthodontics.png" alt="">
          <h3>Prosthodontics</h3>
          <p>Dental World Manila provides prosthodontics or denture services to treat and rehabilitate patients’ oral function, comfort, 
            and appearance. We only use top-quality teeth for your dentures. And you need not wait a long time because we have our laboratory that produces dentures.
</p>
       </div>
 
    </div>
 
 </section>
<!-- services section end -->
<!-- process section start  -->
<section class="process">

    <h1 class="heading">work process</h1>
 
    <div class="box-container container">
 
       <div class="box">
          <img src="images/process1.jpg" width="150px" height="60px" alt='image here'>
          <h3>Cosmetic Dentistry</h3>
          <p>Offers a range of cosmetic treatments to provide patients with a smile makeover that enhances functionality and aesthetics. 
            Services include teeth whitening, reshaping, bonding, porcelain veneers, crowns, and gum grafts. 
            </p>
       </div>
 
       <div class="box">
          <img src="images/process2.jpg" width="150px" height="60px" alt='image here'>
          <h3>Pediatric Dentistry</h3>
          <p>We don’t only provide treatments to improve the dental health of children. Our team welcomingly encourages kids to care for their teeth and orient them properly 
            to eliminate the fear of dentists and dental procedures.</p>
       </div>
 
       <div class="box">
          <img src="images/process3.png" width="150px" height="60px" alt='image here'>
          <h3>Dental Implants</h3>
          <p>Dental implants are root device made of titanium used to replace missing teeth, not just on the surface like regular false teeth but 
            implanted deep into the gums to truly resemble real teeth. </p>
        </div>
 
    </div>
 
 </section>
<!-- process section end -->
          
            <section class="booking" id="booking">
                <div class="container">
                    <div class="row">
                    
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="booking-form">
                                
                                <h2 class="text-center mb-lg-3 mb-2">MAKE AN APPOINTMENT</h2>
                            
                                <form role="form" method="post">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Full name" required='true'>
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email address" required='true'>
                                        </div>
                                   
                                        <div class="col-lg-6 col-12">
                                            <input type="telephone" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number" maxlength="11">
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <input type="date" name="date" id="date" value="" class="form-control">
                                            
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <select name="time" id="" class="form-control">
                                                <option value="" hidden selected>Select Time</option>
                                                <option value="09:00 AM">9:00 AM</option>
                                                <option value="10:00 AM">10:00 AM</option>
                                                <option value="11:00 AM">11:00 AM</option>
                                                <option value="12:00 PM">12:00 PM</option>
                                                <option value="01:00 PM">1:00 PM</option>
                                                <option value="02:00 PM">2:00 PM</option>
                                                <option value="03:00 PM">3:00 PM</option>
                                                <option value="04:00 PM">4:00 PM</option>
                                            </select>
                                        </div>

    <div class="col-lg-6 col-12">
<select onChange="getdoctors(this.value);"  name="specialization" id="specialization" class="form-control" required>
<option value="" hidden selected>Select Service</option>
<!--- Fetching States--->
<?php
$sql="SELECT * FROM tblspecialization";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 
  ?>
<option value="<?php echo $row['ID'];?>"><?php echo $row['Specialization'];?></option>
<?php }?>
</select>
</div>


    <div class="col-lg-6 col-12">
</div>
                                        <div class="col-12">
                                            <textarea class="form-control" rows="5" id="message" name="message" placeholder="Additional Message"></textarea>
                                        </div>

                                        <div class="col-lg-3 col-md-4 col-6 mx-auto">
                                            <button type="submit" class="form-control" name="submit" id="submit-button">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
          
        </main>
<!-- footer section start  -->
<section class="footer" id="footer">

<div class="box-container container">

   <div class="box">
   <i class='bx bx-phone' ></i>
      <h3>Phone Number</h3>
      <p>0909 119 8270</p>
      <p>0967 543 4304</p>
   </div>
   <div class="box">
   
      <a href="https://www.google.com/maps/place/Halipa+Dental+Clinic/@7.3000886,125.6826693,19z/data=!3m1!4b1!4m6!3m5!1s0x32f945ca8c50d2df:0xff89c623c1e8760!8m2!3d7.3000873!4d125.683313!16s%2Fg%2F11lg460fss"><i class='bx bx-current-location' ></i></a>
      
      <h3>Address</h3>
      <p>Door1, 2nd floor, Barrios Bldg. Quezon St., New Pandan, Panabo City</p>
   </div>
   <div class="box">
      <a href="https://www.facebook.com/HalipaDentalClinic"><i class='bx bxl-facebook'></i></a>
      <h3>Facebook</h3>
      <p>Facebook.com/HalipaDentalClinic</p>
      
   </div>
   <div class="box">
   <i class='bx bx-time-five'></i>
      <h3>Business Hours</h3>
      <p>Monday to Saturday
         8:00 AM – 5:00 PM
       </p>
   </div>
</div>
</section>
</main>

<!-- footer section end  -->
        <!-- JAVASCRIPT FILES -->
        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/scrollspy.min.js"></script>
        <script src="js/custom.js"></script>
        


    </body>
</html>