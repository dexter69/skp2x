/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function testRecurency(x) {
                
    if( x > 0 ) {
        console.log('x = ' + x);
        testRecurency(x -1);
    }
}
            
function make_results( gotowe_arr, rest_arr ) {

    var first = rest_arr[0];

    //kopiujemy gotową tablicę
    var rd = gotowe_arr.slice(0);
    var rg = gotowe_arr.slice(0);

    rd.push(Math.floor(first)); // dolne zaokrąglenie
    rg.push(Math.ceil(first)); // górne zaokraglenie


    if( rest_arr.length > 1) { // stan normalny
        rest_arr.shift();
        rd = make_results( rd, rest_arr );
        rg = make_results( rg, rest_arr );
        return rd.concat(rg);


    } else { // stan terminalny


        return [rd, rg];
    }
}

function wszystkie_kombinacje_test( theBuild, theSource) {
    
    var i, j, row, tmpTab, tmpBuild, fresult = [];
    
    console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>');
    console.log('theBuild = ', theBuild);
    console.log('theSource = ', theSource);
    if( theSource.length === 0 )  { //stan terminalny, nie ma co robić
        console.log('one', theBuild);
        return theBuild; // zwracamy gotową, kompletną tablicę
    } else {
        if( theBuild.length === 0 ) { //znaczy - pierwszy przebieg            
            //var tmpTab = theSource[0];
            tmpTab = theSource.shift();
            //console.log(tmpTab);
            for( i = 0; i < tmpTab.length; i++ ) {
                theBuild.push([tmpTab[i]]);
            }
            /*console.log('theBuild', theBuild);
            console.log('oraz theSource', theSource);*/
            //console.log('two', theBuild);
            console.log('two');
            //document.getElementById("two").innerHTML = JSON.stringify(theBuild);
            fresult = wszystkie_kombinacje_test( theBuild, theSource);
        } else {
            console.log(theBuild);
            tmpTab = theSource.shift();/*
            document.getElementById("three").innerHTML = 'theBuild = ' + JSON.stringify(theBuild);
            document.getElementById("tmp").innerHTML = 'theBuild.length = ' + JSON.stringify(theBuild.length);
            document.getElementById("tmp1").innerHTML = 'tmpTab = ' + JSON.stringify(tmpTab);
            document.getElementById("tmp2").innerHTML = 'tmpTab.length = ' + JSON.stringify(tmpTab.length);
            */tmpBuild = []; row = []; var k = 0;
            for( i = 0; i < theBuild.length; i++ ) {
                for( j = 0; j < tmpTab.length; j++ ) {
                    row = theBuild[i].slice(0);
                    row.push(tmpTab[j]);
                    tmpBuild.push(row);
                    if( i === 0 && j === 1) {
                        //document.getElementById("tmp3").innerHTML = 'tmpBuild = ' + JSON.stringify(tmpBuild);
                    }
                    k++;
                }
            }
            //document.getElementById("three").innerHTML = JSON.stringify(tmpBuild);
            console.log(k);
            console.log('three');
            theBuild = tmpBuild;
            //console.log('three', tmpBuild);
            fresult = wszystkie_kombinacje_test( theBuild, theSource);
        }
        return fresult;
    }
    
}

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< LOOP
function makeSource( tab ) {

    var retab = [];
    for (var i = 0; i < tab.length; i++) {
        var tmp = [ Math.floor(tab[i]), Math.ceil(tab[i]) ];
        retab.push(tmp);
    }
    //console.log(retab);
    return retab;
}

function makeIndTab( sTab ) {

    var ind = [];

    for (var i = 0; i < sTab.length; i++) {
            //ind.push(sTab[i].length-1);
            ind.push(0);
    }
    //console.log(ind);
    return ind;
}

function incInd(ind, sou) {

    var i = ind.length-1;
    var konec = false;

    while( !konec && i>=0 ) {

            if( ind[i]+1 < sou[i].length ) {
                    ind[i]++; konec = true;
            } else {
                    ind[i--] = 0;
            }

    }
    if( konec ) return(ind); else return([]);
}

function makeRow( ind, sou ) {

        var row = [];
        for (var i = 0; i < ind.length; i++) {
                row.push(sou[i][ind[i]]);
        }
        return row;
}

function gibon(wart) {

    var theSource = makeSource(wart);
    var indTab = makeIndTab( theSource );

    var result = [];

    while( indTab.length ) {

        var row = makeRow( indTab, theSource);
        result.push(row);
        indTab = incInd(indTab, theSource);

    }
    console.log(result);
}