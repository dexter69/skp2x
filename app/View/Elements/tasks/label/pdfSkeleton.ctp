<script>
// umieszczamy "szkielet" skryptu pod pdfmake w elemencie, bo tak nam wygodnie
    
    var docDefinitionx = { 
        content: 'żźćńłśąęó This is an sample PDF printed with pdfMake',
        
        pageSize: { width: 113, height: 198 }, // w pkt =< to daje mniej więcej 70 x 40 mm

        // by default we use portrait, you can change it to landscape if you wish
        pageOrientation: 'landscape',
        
        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
        pageMargins: [ 10, 8, 10, 8 ]
    };
    
    var docDefinition = {
        content: [
          /*
          { text: 'This is a header', style: 'header' },
          'No styling here, this is a standard paragraph',
          { text: 'Another text', style: 'textlabel' },
          { text: 'Multiple styles applied', style: [ 'header', 'anotherStyle' ] }
          */
        ],

        styles: {
          textlabel: {
              fontSize: 7
          },
          product: {
            fontSize: 11,
            bold: true
          },
          anotherStyle: {
            italics: true,
            alignment: 'right'
          }
        },
        
        pageSize: { width: 113, height: 198 }, // w pkt =< to daje mniej więcej 70 x 40 mm

        // by default we use portrait, you can change it to landscape if you wish
        pageOrientation: 'landscape',
        
        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
        pageMargins: [ 10, 10, 10, 10 ]
        
      };
    
</script>