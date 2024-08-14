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

                 <?php

                    use app\core\Application;

                    if (Application::$app->session->get("user_role") == 3) : ?>

                     <a href="<?php echo "/allocate?id=$user->id" ?>" class="btn-approve">Allocate</a>
                 <?php endif ?>

                 <?php if ($request->{"join_status"} == "pending") : ?>
                     <button onclick='approveJoin(<?php echo json_encode($request->{"id"}); ?>)' class="btn-approve">Approve</button>
                     <button onclick='rejectJoin(<?php echo json_encode($request->{"id"}); ?>)' class="btn-reject">Reject</button>
                 <?php endif ?>

                 <?php if ($user->{"status"} == "active") : ?>
                     <button onclick='deactivateUser(<?php echo json_encode($user->{"id"}); ?>)' class="btn-reject">Deactivate</button>
                 <?php else : ?>
                     <button onclick='activateUser(<?php echo json_encode($user->{"id"}); ?>)' class="btn-approve">Activate</button>
                 <?php endif ?>

             </div>
         </div>

         <div class="grid">
             <?php foreach ($user as $key => $value) : ?>
                 <?php if ($key == "errors") : ?>
                     <?php continue; ?>
                 <?php endif ?>
                 <?php if ($key == "id") : ?>
                     <?php continue; ?>
                 <?php endif ?>
                 <?php if ($key == "password") : ?>
                     <?php continue; ?>
                 <?php endif ?>
                 <?php if ($key == "confirmPassword") : ?>
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
     function deactivateUser(data) {
         const url = `user-deactivate?id=${data}`
         fetch(url).then((res) => {
             if (res.ok) {
                 showModal("success", "User deactivated successfully!")
             } else {
                 showModal("error", "Failed to deactivate user")
             }
         })
     }

     function activateUser(data) {
         const url = `user-activate?id=${data}`
         fetch(url).then((res) => {
             if (res.ok) {
                 showModal("success", "User activated successfully!")
             } else {
                 showModal("error", "Failed to activate user")
             }
         })
     }
 </script>