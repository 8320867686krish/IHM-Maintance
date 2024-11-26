 <div>
     <table class="table table-striped table-bordered first" width="100%">
         <thead>
             <tr>
                 <th>Sr No</th>
                 <th>Sample No</th>
                 <th>Type</th>
                 <th>Hazmat Type</th>
                 <th>Location</th>
                 <th>Equip. & Comp.</th>
                 <th>Hazmat</th>
                 <th>IHM Part</th>
                 <th colspan="2">Approximate Quantity</th>
                 <th>Remarks</th>
                 @can('ships.edit')
                 <th width="10%">Action</th>
                 @endcan
             </tr>
         </thead>
         <tbody id="checkListTable">
             <x-all-check-list :checks="$checks"></x-all-check-list>

         </tbody>
     </table>
 </div>
