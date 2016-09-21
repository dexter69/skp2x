<?php
$this->layout='pdfmake';
//echo "metoda przygotowująca dane, do wyświetlenia etykiet w formacie pdf.";

?>
<script>
    var docDefinition = { 
        content: 'This is an sample PDF printed with pdfMake',
        // a string or { width: number, height: number }
        //pageSize: 'A5',
        pageSize: { width: 113, height: 198 }, // w pkt =< to daje mniej więcej 70 x 40 mm

        // by default we use portrait, you can change it to landscape if you wish
        pageOrientation: 'landscape'
    };
    
    // open the PDF in a new window
    pdfMake.createPdf(docDefinition).open();
    
     // print the PDF (temporarily Chrome-only)
    //pdfMake.createPdf(docDefinition).print();
    
    //// download the PDF (temporarily Chrome-only)
    //pdfMake.createPdf(docDefinition).download('optionalName.pdf');
</script>