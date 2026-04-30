// var h1 = $('h1');
// console.log(h1.text());
// h1.text('Hello World');

// var a = $('a');
// a.attr('href', 'https://www.google.com');
// a.attr('target', '_blank');
// var checkbox = $('#meh');
// console.log(checkbox.prop('checked'));

// var form = $('#formhtml');
// form.on('submit', function(e) {
//     e.preventDefault();
//     var checkbox = $('#meh');
//     console.log(checkbox.prop('checked'));
// });

// form.on('submit',function(e){
//     e.preventDefault();
//     console.log(checkbox.prop('checked'));
//     checkbox.attr('checked', 'checked');
//     console.log(checkbox.prop('checked'));
// });

// var link = $('<a>',{
//     href: 'https://www.example.com',
//     target: '_blank',
//     text: 'Example Link',
//     css: {
//         'text-decoration': 'none'
//     }
// });
// $('body').append(link);
// link.attr('href', 'https://www.example.com');
// link.attr('target', '_blank');
// link.text('Example Link');
// link.css('text-decoration', 'none');
// $('body').append(link);

// var link = $('<a></a>');
// link.attr({
//     href: 'https://www.example.com',
//     target: '_blank'
// });
// link.text('Example Link');
// link.css('text-decoration', 'none');

// $('#gallery-items').wrap(link);

// $(document).ready(function(){
//     $('#gallery-items').hide();
//     $('#wrap-button').animate({left:'495px'},1000);
//     $('#wrap-button').on('mouseenter',function(){
//         $('#gallery-items').slideDown(500);
//     });
//     $('#wrap-button').on('mouseleave',function(){
//         $('#gallery-items').slideUp(500);
//     });
// });

// $('#wrap-button').on('click', function() {
//     console.log('Button clicked');
//     //create xhr object
//     const xhr = new XMLHttpRequest();

//     console.log(xhr);

//     //open the object
//     xhr.open('GET','sample.txt',true);

//     // xhr.onload = function(){
//     //     if(this.status === 200){
//     //         console.log(this.responseText);
//     //     }
//     // }

//     xhr.onreadystatechange = function(){
//         if(this.readyState === 4 && this.status === 200){
//             console.log(this.responseText);
//     }

//     xhr.send();
// });
// random number between 1 and 10


// task 1
// var randomnum = Math.random() * 10 + 1;
// round down to nearest whole number;
// randomnum = Math.floor(randomnum);
// document.getElementById('formhtml').addEventListener('submit',function(e){
//     e.preventDefault();
//     var usernum = document.getElementById('numberInput').value
//     if(usernum == randomnum){
//         alert('Congratulations! You guessed the correct number: ' + randomnum);
//     } else {
//         alert('Sorry, the correct number was ' + randomnum + '. Please try again!');
//     }
// });
// console.log(randomnum);



// task 2
// document.getElementById('formhtml').addEventListener('submit',function(e){
//     e.preventDefault();
//     num1 = document.getElementById('numberInput').value;
//     num2 = document.getElementById('numberInput1').value;
//     console.log('value of num1: ' + num1);
//     console.log('value of num2: ' + num2);
//     var multi = num1 * num2;
//     console.log('The multiplication of ' + num1 + ' and ' + num2 + ' is: ' + multi);
//     var divistion = num1 / num2;
//     console.log('The division of ' + num1 + ' by ' + num2 + ' is: ' + divistion);
// })


// task 3 
// document.getElementById('formhtml').addEventListener('submit',function(e){
//     e.preventDefault();
//     num1 = document.getElementById('numberInput').value;
//     num2 = document.getElementById('numberInput1').value;
//     console.log('value of num1: ' + num1);
//     console.log('value of num2: ' + num2);
//     if (num1 == num2){
//         var sum = parseInt(num1) + parseInt(num2);
//         console.log('Initial sum: ' + sum);
//         sum = sum * 3;
//         console.log('The two numbers are equal:' + sum);
//     }else{
//         var sum = parseFloat(num1) + parseFloat(num2);
//         console.log('The two numbers are not equal: ' + sum);
//     }
// });

// task 4
// $(document).ready(function(){
//     $('#gallery-items').hide();
//     $('#wrap-button').on('mouseenter',function(){
//         $('#gallery-items').slideDown(500);
//     })
//     $('#wrap-button').on('mouseleave',function(){
//         $('#gallery-items').slideUp(500);
//     });
// });

// task 5
// $(document).ready(function() {
//     var $password = $('#password');

//     // Validate as the user types or leaves the field
//     $password.on('input', function() {
//         var value = $(this).val();
//         if (value.length < 4) {
//             console.log('Password must be at least 4 characters long');
//             // Optionally show an error message in HTML:
//             // $('#password-error').text('Password too short!');
//         } else {
//             console.log('Password length is sufficient');
//             // $('#password-error').text('');
//         }
//     });
// });

// task 6
// var usernames = ['user1', 'user2', 'user3'];

// $('#formhtmlPassword').on('submit', function(e){
//     e.preventDefault();
//     var inputUsername = document.getElementById('username').value;
//     usernames.forEach(function(user){
//         if(inputUsername === user){
//             console.log('Username already taken');
//         }
//     });
// });

// task 7
// document.getElementById('formhtmlPassword').addEventListener('submit', function(e){
//     e.preventDefault();
//     var inp = document.getElementById('username').value
//     var num = document.getElementById('number').value
//     inp = inp.split('');
//     inp[num] = '';
//     inp = inp.join('');
//     console.log(inp);
// })


// task 8
//     function createXHR() {
//       const xml = new XMLHttpRequest();
      
//       // ✅ Correct URL (no spaces, proper endpoint)
//       xml.open('GET', 'https://maas.atmmessinaspa.it/api/lista-linee', true);
      
//       xml.onreadystatechange = function() {
//         if (this.readyState === 4) {
//           const output = document.getElementById('output');
          
//           if (this.status === 200) {
//             try {
//               const data = JSON.parse(this.responseText);
              
//               // ✅ Check if it's an array and show its size
//               if (Array.isArray(data)) {
//                 output.innerHTML = `<p>Number of linee: ${data.length}</p>`;
//               } else {
//                 output.innerHTML = '<p>Error: Response is not an array</p>';
//               }
//             } catch (e) {
//               output.innerHTML = '<p>Error: Invalid JSON response</p>';
//               console.error(e);
//             }
//           } else {
//             output.innerHTML = `<p>Error: HTTP ${this.status}</p>`;
//           }
//         }
//       };
      
//       xml.send();
//     }

//     document.getElementById('wrap-button').addEventListener('click', function(e) {
//       e.preventDefault();
//       createXHR();
//     });
// carname = "Volvo";
// console.log(typeof carname)
// carname = new String("Volvo");
// console.log(typeof carname)
// console.log(carname.length)
// console.log(carname.slice(0,3))

// const x = 0.0;
// console.log(typeof x);
// const y = "0";
// console.log(typeof y);

// if (x === y){
//     console.log('x and y are equal');
// } else {
//     console.log('x and y are not equal');
// }


// function person(name){
//     this.name = name;
//     lastname : 'Doe';
// }
// let myFather = new person('John');
// console.log(myFather.name + ' ' + myFather.lastname);

// let x = "we are \"Vikings\" from the north";
// x = x.toUpperCase();
// let x = "I can eat bananas all day";
// x = ` ${x}  `;
// // x = x.(' ');
// x = x.toLowerCase();
// console.log(x.instr);


// let text = "Hello World";
// let result = text.includes("World");
// let newElement = document.createElement('p');
// console.log(newElement);
// newElement = newElement.innerHTML = result;
// let add = document.getElementsByTagName('main')[0].innerHTML = result;

// let x = document.createElement('p');
// x.id = 'newPara';
// x.className = 'paraClass';
// x.innerHTML = "This is a new paragraph created using JavaScript.";
// console.log(x);
// document.getElementsByTagName('main')[0].appendChild(x);