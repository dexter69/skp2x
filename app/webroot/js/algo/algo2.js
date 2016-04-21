function makeSource( tab ) {

    var dolne, gorne, retab = [];
    
    for (var i = 0; i < tab.length; i++) {
        dolne = Math.floor(tab[i]); gorne = Math.ceil(tab[i]);
        if( dolne === gorne ) { // przypadek zaokrąglania całkowitych            
            retab.push([ dolne-2, dolne-1, dolne, dolne+1, dolne+2 ]);
        } else {
            retab.push([ dolne-1, dolne, gorne, gorne+1 ]);
        }
    }
    return retab;
}

function kombinuj( theBuild, theSource) {
    
    var i, j, row, tmpTab, tmpBuild;
    
    if( theSource.length === 0 )  { //stan terminalny, nie ma co robić
        return theBuild; // zwracamy gotową, kompletną tablicę
    } else {
        if( theBuild.length === 0 ) { //znaczy - pierwszy przebieg            
            tmpTab = theSource.shift();
            for( i = 0; i < tmpTab.length; i++ ) {
                theBuild.push([tmpTab[i]]);
            }
            return kombinuj( theBuild, theSource);
        } else {
            tmpTab = theSource.shift();
            tmpBuild = [];
            for( i = 0; i < theBuild.length; i++ ) {
                for( j = 0; j < tmpTab.length; j++ ) {
                    row = theBuild[i].slice(0);
                    row.push(tmpTab[j]);
                    tmpBuild.push(row);
                }
            }
            return kombinuj( tmpBuild, theSource);
        }
    }
}

