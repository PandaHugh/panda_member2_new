<table style="width:100%">
         <thead>
          <?php foreach($result->list_fields() as $row)
                { ?>
              <tr>
                <th>Branch Name</th>
                
              </tr>
            <?php } ?>
              </thead>
              <tbody>

                <?php foreach($result->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->Name?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                
                <?php } ?>
               
              </tbody>
        </table>