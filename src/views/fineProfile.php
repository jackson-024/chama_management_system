 <div class="container">
     <div class="header">
         <div class="left">
             <h1>User Profile</h1>
         </div>
         <div>
             <button onclick="history.back()" class="btn-back">Back</button>
         </div>
     </div>

     <div class="chama-details">
         <div class="flex">
             <div class="">
                 <h3 class="title">User Details</h3>
             </div>

             <div>



                 <?php if ($fine->{"status"} == "not_cleared") : ?>
                     <a href="pay-fine?id=<?php echo  $fine->{"id"} ?>" class="btn-approve">Pay fine</a>
                 <?php endif ?>


             </div>
         </div>

         <div class="grid">
             <?php foreach ($fine as $key => $value) : ?>
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
     function repayFine(id) {
         const url = `repayfine?id=${id}`;
         fetch(url).then((res) => {
             if (res.ok) {
                 window.location.reload;
             }
         })
     }
 </script>