 <div class="container">
     <div class="header">
         <div class="left">
             <h1>Loan Product Profile</h1>
         </div>
         <div>
             <button onclick="history.back()" class="btn-back">Back</button>
         </div>
     </div>

     <div class="chama-details">
         <div class="flex">
             <div class="">
                 <h3 class="title">Product Details</h3>
             </div>

             <div>
                 <?php if ($loanProd->status == "active") : ?>
                     <button onclick='deactivateLoanProduct(<?php echo json_encode($loanProd->{"id"}); ?>)' class="btn-reject">Deactivate</button>
                 <?php endif; ?>
             </div>
         </div>

         <div class="grid">
             <?php foreach ($loanProd as $key => $value) : ?>
                 <?php if ($key == "errors") : ?>
                     <?php continue; ?>
                 <?php endif ?>

                 <p class="detail">
                     <?php echo $key; ?>:
                     <span class="detail-value">
                         <?php echo $value; ?>
                     </span>
                 </p>
             <?php endforeach ?>
         </div>
     </div>
 </div>

 <script>
     function deactivateLoanProduct(data) {
         const url = `deactivate-loan-product?id=${data}`;
         fetch(url).then((res) => {
             if (res.ok) {
                 showModal("success", "Loan deactivation success")
             } else {
                 showModal("error", "Loan deactivation failed")
             }
         })
     }
 </script>