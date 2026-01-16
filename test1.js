// let str = "welcome to the Gym Management System!";
// str = str.split('');
// document.getElementById('form').addEventListener('submit',function(e){
//     e.preventDefault();
//     let val = document.getElementById('number').value;
//     str[val] = '';
//     alert(str.join(''));
// })
// document.getElementById('formhtmlPassword').addEventListener('submit', function(e){
//     e.preventDefault();
//     var inp = document.getElementById('username').value
//     var num = document.getElementById('number').value
//     inp = inp.split('');
//     inp[num] = '';
//     inp = inp.join('');
//     console.log(inp);
// })

let arr = [1,2,'hello',true,false,null,undefined,{name:'John'},[10,11,12]];
function inspectValues(arr){
    let newArr = [];
    arr.forEach(function(val){
        itemArr =[];
        itemArr.push(val);
        itemArr.push(typeof val);
        newArr.push(itemArr);
    });
    return newArr;
}
console.log(inspectValues(arr));


