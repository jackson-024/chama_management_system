 <div class="mx-4">
     <div class="header pb-4">
         <div class="left">
             <h1>Chama Profile</h1>
         </div>
         <div>
             <button onclick="history.back()" class="rounded-md px-3.5 py-2.5 text-sm font-semibold text-indigo-600 border border-indigo-600 shadow-sm hover:bg-indigo-500 hover:text-white">
                 Back
             </button>
         </div>
     </div>

     <!-- <?php var_dump($chama); ?> -->


     <div class="border-2 px-10 py-6 gap-3">
         <div class="flex justify-between">
             <div class="">
                 <h3 class="text-lg font-bold">Chama Details</h3>
             </div>

             <div>
                 <?php if ($chama->{"status"} == "pending") : ?>

                     <button onclick='approveChama(<?php echo json_encode($chama->{"id"}); ?>)' class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Approve</button>
                     <button onclick='rejectChama(<?php echo json_encode($chama->{"id"}); ?>)' class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Reject</button>

                 <?php endif ?>

             </div>
         </div>
         <div class="grid md:grid-cols-2 lg:grid-cols-3 mt-4">
             <?php foreach ($chama as $key => $value) : ?>
                 <?php if ($key == "errors") : ?>
                     <?php continue; ?>
                 <?php endif ?>
                 <?php if ($key == "id") : ?>
                     <?php continue; ?>
                 <?php endif ?>
                 <p class="font-medium capitalize">
                     <?php echo $key; ?>:
                     <span class="text-indigo-600">
                         <?php echo $value; ?>
                     </span>
                 </p>
             <?php endforeach ?>
         </div>
     </div>
 </div>