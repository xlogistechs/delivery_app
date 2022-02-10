<?php 
if(isset($_SESSION[PRE_FIX.'id']))
{  
    $url=$baseurl . 'showUsers'; 
    $data =array(
        'role' => 'rider'
    );
    
        
    $json_data=@curl_request($data,$url);
    
    $allusers = [];
    if ($json_data['code'] == 200) {
        $allusers = $json_data['msg'];
    }
?>
<div class="qr-content">
    <div class="qr-page-content">
        <div class="qr-page zeropadding">
            <div class="qr-content-area">
                <div class="qr-row">
                    <div class="qr-el">

                        <div class="page-title">
                            <h2>All Riders</h2>
                            <div class="head-area">
                            </div>
                        </div>
                        <div class="right" style="padding: 10px 0;">
                            <button onclick="addrider()"
                                class="com-button com-submit-button com-button--large com-button--default">
                                <div class="com-submit-button__content"><span>Add Rider</span></div>
                            </button>
                        </div>
                        <table id="table_view" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Online</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($json_data!="")
                                {
                                    foreach ($json_data['msg'] as $singleRow): 
                            ?>
                                <tr>
                                    <td><?php echo $singleRow['User']['id'] ?></td>
                                    <td style="width:150px; overflow:hidden;">
                                        <?php echo ucwords($singleRow['User']['first_name'].' '. $singleRow['User']['last_name']); ?><br>
                                        <?php echo $singleRow['User']['phone'] ?>
                                    </td>
                                    <td style="width:150px; overflow:hidden;"><?php echo $singleRow['User']['email'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($singleRow['User']['online'] =="1" )
                                        {
                                            echo "<span style='color:green; text-transform: capitalize;'>Online</span>";
                                        }
                                        else
                                        {
                                            echo "<span style='color:orange; text-transform: capitalize;'>Ofline</span>";  
                                        }
                                    ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($singleRow['User']['active']=="0")
                                            {
                                                echo "Active";
                                            }
                                            else
                                            if($singleRow['User']['active']=="1")
                                            {
                                                echo "<span style='color:red; text-transform: capitalize;'>Blocked</span>"; 
                                            }
                                            else
                                            if($singleRow['User']['active']=="2")
                                            {
                                                echo "Pending";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $singleRow['User']['created'] ?></td>
                                    <td>
                                        <div class="more">
                                            <button id="more-btn" class="more-btn">
                                                <span class="more-dot"></span>
                                                <span class="more-dot"></span>
                                                <span class="more-dot"></span>
                                            </button>
                                            <div class="more-menu">
                                                <div class="more-menu-caret">
                                                    <div class="more-menu-caret-outer"></div>
                                                    <div class="more-menu-caret-inner"></div>
                                                </div>
                                                <ul class="more-menu-items" tabindex="-1" role="menu"
                                                    aria-labelledby="more-btn" aria-hidden="true">
                                                    <li class="more-menu-item" role="presentation"
                                                        onclick="editRider(<?php echo $singleRow['User']['id'] ?>)">
                                                        <button type="button" class="more-menu-btn"
                                                            role="menuitem">Edit</button>
                                                    </li>
                                                    <li class="more-menu-item" role="presentation"
                                                        onclick="changeStatus(<?php echo $singleRow['User']['id'] ?>)">
                                                        <button type="button" class="more-menu-btn"
                                                            role="menuitem">Change Status</button>
                                                    </li>
                                                    
                                                    <li class="more-menu-item" role="presentation"
                                                        onclick="showDocuments(<?php echo $singleRow['User']['id'] ?>)">
                                                        <button type="button" class="more-menu-btn"
                                                            role="menuitem">Documents</button>
                                                    </li>
                                                    
                                                    <li class="more-menu-item" role="presentation"
                                                        onclick="changeRiderPassword(<?php  echo $singleRow['User']['id'] ?>)">
                                                        <button type="button" class="more-menu-btn"
                                                            role="menuitem">Change Password</button>
                                                    </li>
                                                    <li class="more-menu-item" role="presentation"
                                                        onclick="return ConfirmDelete()">
                                                        <a href="process.php?action=deleteRider&id=<?php  echo $singleRow['User']['id'] ?>">
                                                            <button type="button" class="more-menu-btn" role="menuitem">Delete</button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                endforeach; 
                            }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Online</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table_view').DataTable({
            "pageLength": 15
        });
    });
</script>
<?php
    } 
    else 
    {
        
        echo "<script>window.location='index.php'</script>";
        die;
        
    } 
?>