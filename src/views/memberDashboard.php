         <div class="header">
             <div class="left">
                 <h1>Member Dashboard</h1>
             </div>
         </div>

         <!-- Insights -->
         <ul class="insights">
             <!-- <li>
                 <i class='bx bx-calendar-check'></i>
                 <span class="info">
                     <h3>
                         1,074
                     </h3>
                     <p>Chama Groups</p>
                 </span>
             </li> -->
             <li><i class='bx bx-show-alt'></i>
                 <span class="info">
                     <h3>
                         <?php echo number_format($lastUWRecord["balance"]) ?>
                     </h3>
                     <p>Total Contributed</p>
                 </span>
             </li>

             <li><i class='bx bx-line-chart'></i>
                 <span class="info">
                     <h3>
                         <?php echo number_format($lastChamaRecord["balance"]) ?>
                     </h3>
                     <p>Total Chama Revenue</p>
                 </span>
             </li>
             <!-- <li><i class='bx bx-dollar-circle'></i>
                 <span class="info">
                     <h3>
                         $6,742
                     </h3>
                     <p>Total Sales</p>
                 </span>
             </li> -->
         </ul>
         <!-- End of Insights -->