<div id="proof-preview" class="proof-stuff">
    <table class="proof1" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th id="kwi" data-lan="DETE">DATA</th>
                <th>ZAMÓWIENIE</th>
                <th>ILOŚĆ</th>
                <th>CENA</th>
                <th>ZAMÓWIENIE KLIENTA</th>
            </tr>
        </thead>  
        <tbody>
            <tr>
                <td id="burok" contenteditable="true"><?php echo date("d.m.Y"); ?></td>
                <td><?php echo $comm['handlowe']; ?></td>
                <td><?php echo $comm['ilosc']; ?></td>
                <td><?php echo $comm['cena']; ?></td>
                <td><?php echo $proof['customer_nr']; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php
$this->Proof->printR($proof);
//$this->Proof->printR($lang);