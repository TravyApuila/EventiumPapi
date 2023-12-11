<!-- payment.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Payment Page</title>
</head>

<body class="my-login-page">


    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <center>
                    <div class="brand">
                        <img src="eventium.jpg" alt="Eventium Logo" style="width: 50%;">
                    </div>
                    </center>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Payment Page</h4>

                            <form action="simpanpayment.php" method="POST" class="my-login-validation">
                                <div class="form-group">
                                    <label for="fullname">Full Name</label>
                                    <input id="fullname" type="text" class="form-control" name="fullname" required autofocus>
                                    <div class="invalid-feedback">
                                        Please add your Full Name!
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input id="email" type="email" class="form-control" name="email" required>
                                    <div class="invalid-feedback">
                                        Please add your Email Address!
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input id="phone" type="text" class="form-control" name="phone" required>
                                    <div class="invalid-feedback">
                                        Please add your Phone Number!
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="service">Eventium Service</label>
                                    <select class="form-control" name="service" id="service" onchange="updatePackageDropdown()" required>
                                        <option value="0" disabled selected>-Select-</option>
                                        <option>Event Organizer</option>
                                        <option>Hall Reservation</option>
                                        <option>EO & Hall Reservation</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="package">Eventium Package</label>
                                    <select class="form-control" name="package" id="package" onchange="updateTotal()" required>
                                        <option value="0" disabled selected>-Select-</option>
                                        <option value="Gold">Gold</option>
                                        <option value="Diamond">Diamond</option>
                                        <option value="Platinum">Platinum</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input id="date" type="date" class="form-control" name="date" required>
                                    <div class="invalid-feedback">
                                        Please add the Date!
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" class="form-control" id="note" cols="30" rows="10"
                                        placeholder="Write down your order details"></textarea>
                                    <div class="invalid-feedback">
                                        Please add the Note!
                                    </div>
                                </div>

                                <!-- Pricing display -->
                                <div id="totalPrice" class="mt-3"></div>
                                <div class="form-group m-0">

                                    <button type="submit" class="btn btn-primary btn-block">
                                        Buy
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var serviceDropdown = document.getElementById('service');
            var packageDropdown = document.getElementById('package');
    
            // Disable package dropdown initially
            packageDropdown.disabled = true;
    
            // Add event listener to service dropdown
            serviceDropdown.addEventListener('change', function () {
                // Enable or disable the package dropdown based on the selected service
                packageDropdown.disabled = serviceDropdown.value === "0";
    
                // Reset package selection when service changes
                if (serviceDropdown.value === "0") {
                    packageDropdown.value = "0";
                }
    
                // Update the total when the service changes
                updateTotal();
            });
    
            // Add event listener to package dropdown
            packageDropdown.addEventListener('change', function () {
                // Update the total when the package changes
                updateTotal();
            });
        });
    
        function updateTotal() {
            var packagePrice = 0;
            var selectedPackage = document.getElementById('package').value;
            var selectedService = document.getElementById('service').value;
    
            // Update package price based on the selected service
            if (selectedService === "Event Organizer") {
                if (selectedPackage === "Gold") {
                    packagePrice = 4198;
                } else if (selectedPackage === "Diamond") {
                    packagePrice = 5490;
                } else if (selectedPackage === "Platinum") {
                    packagePrice = 12950;
                }
            } else if (selectedService === "Hall Reservation") {
                if (selectedPackage === "Gold") {
                    packagePrice = 9710;
                } else if (selectedPackage === "Diamond") {
                    packagePrice = 18919;
                } else if (selectedPackage === "Platinum") {
                    packagePrice = 32299;
                }
            } else if (selectedService === "EO & Hall Reservation") {
                if (selectedPackage === "Gold") {
                    packagePrice = 14201;
                } else if (selectedPackage === "Diamond") {
                    packagePrice = 25851;
                } else if (selectedPackage === "Platinum") {
                    packagePrice = 45185;
                }
            }
    
            var totalPrice = packagePrice;
            document.getElementById('totalPrice').innerHTML = 'Total Price: $' + totalPrice.toLocaleString('en-US', { maximumFractionDigits: 3 });
        }
    </script>
    
    
</body>

</html>
