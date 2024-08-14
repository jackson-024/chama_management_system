         <div class="header">
             <div class="left">
                 <h1>Secretary Dashboard</h1>
             </div>
         </div>

         <!-- Insights -->
         <ul class="insights">
             <li><i class='bx bx-show-alt'></i>
                 <span class="info">
                     <h3>
                         <?php echo number_format(count($users)) ?>
                     </h3>
                     <p>Total Users</p>
                 </span>
             </li>

             <li><i class='bx bx-line-chart'></i>
                 <span class="info">
                     <h3>
                         <?php echo number_format($lastUWRecord["balance"]) ?>

                     </h3>
                     <p>User Wallet Balance</p>
                 </span>
             </li>

             <li><i class='bx bx-line-chart'></i>
                 <span class="info">
                     <h3>
                         <?php echo number_format($lastChamaRecord["balance"]) ?>

                     </h3>
                     <p>Chama Wallet Balance</p>
                 </span>
             </li>


             <li><i class='bx bx-show-alt'></i>
                 <span class="info">
                     <h3>
                         <?php echo number_format(count($chamaLoans)) ?>
                     </h3>
                     <p>Total loans</p>
                 </span>
             </li>



             <li><i class='bx bx-show-alt'></i>
                 <span class="info">
                     <h3>
                         <?php echo number_format(count($fines)) ?>
                     </h3>
                     <p>Fines</p>
                 </span>
             </li>
         </ul>
         <!-- End of Insights -->



         <div class="grid">
             <div class="container card-card">
                 <p class="detail">Upcoming meetings</p>

                 <?php if ($meetings) : ?>
                     <ul class="card-list">
                         <?php foreach ($meetings as $meeting => $value) : ?>
                             <li>
                                 <div class="card-card">
                                     <p class="">
                                         Date:
                                         <span class="card-text">
                                             <?php echo $value['date']; ?>
                                         </span>
                                     </p>
                                     <p class="">
                                         Time:
                                         <span class="card-text">
                                             <?php echo $value['time']; ?>
                                         </span>
                                     </p>
                                     <p class="">
                                         Venue:
                                         <span class="card-text">
                                             <?php echo $value['venue']; ?>
                                         </span>
                                     </p>
                                     <p class="">
                                         Purpose:
                                         <span class="card-text">
                                             <?php echo $value['purpose']; ?>
                                         </span>
                                     </p>

                                 </div>
                             </li>
                         <?php endforeach; ?>
                     </ul>
                 <?php else : ?>
                     <div class="text-container">
                         <p class="info">No upcoming meetings</p>
                     </div> <?php endif; ?>
                 <a class="card-button" href="/create-meeting">Schedule meeting</a>

             </div>
         </div>