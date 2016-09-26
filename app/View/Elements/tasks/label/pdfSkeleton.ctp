<script>
// umieszczamy "szkielet" skryptu pod pdfmake w elemencie, bo tak nam wygodnie

    var docDefinition = {
        content: [],        
        styles: {
          textlabel: {
              fontSize: 7
          },          
          product: {
            fontSize: 11,
            margin: [0, 0, 0, 3],
            bold: true
          },
          normal: {
            fontSize: 11,
            margin: [0, 0, 0, 3]
          },
          numer: {
            fontSize: 8,
            alignment: 'right'
          }
        },
        
        pageSize: { width: 113, height: 198 }, // w pkt => to daje mniej więcej 40 x 70 mm

        // by default we use portrait, you can change it to landscape if you wish
        pageOrientation: 'landscape',
        
        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
        pageMargins: [ 12, 10, 8, 8 ]
        
      };
    
</script>