<?php
if(isset($_GET['delete_payment_account'])){
    delete_payment_account($_GET['delete_payment_account']);
    header('Location:'.$_SERVER['HTTP_REFERER']);
}
function print_accounts($method){
    $accounts = select_payment_accounts($method);
    $table_accounts = '<table class="table-accounts" >
                                <thead>
                                <th>n</th>
                                <th>Banco</th>
                                <th>PAis</th>
                                <th>Metodo</th>
                                <th>Dni</th>
                                <th>Titular</th>
                                <th>Estado</th>
                                    {thdata}
                                <th>actions</th>
                                </thead>
                                <tbody>
                                    {bodydata}
                                </tbody>
                            </table>
                        ';
    
    $tr = "";
    global $th;
    foreach($accounts as $key => $account):
        $tr .= '<tr>
        <td>'.($key+1).'</td>
        <td>'.$account->bank_name.'</td>
        <td>'.$account->country_code.'</td>
        <td>'.str_replace("_"," ",$account->payment_method).'</td>
        <td>'.$account->dni.'</td>
        <td>'.$account->titular.'</td>
        <td><div class="'.($account->status == 1? "enable":"disable").'" ></div></td>';
        $th = "";
        foreach ($account->metas as $key => $meta) :
            $tr .= '<td>'.$meta->value.'</td>';
            $th .= '<th>'.str_replace("_"," ",$meta->key).'</th>';
        endforeach;
        $tr .= '<td><a href="?delete_payment_account='.$account->id.'">delete</a></td></tr>';
    endforeach;
    $table_accounts = str_replace('{thdata}',$th,$table_accounts);
    $table_accounts = str_replace('{bodydata}',$tr,$table_accounts);
    return $table_accounts;
}