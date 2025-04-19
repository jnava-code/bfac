if(document.querySelector('.profile')) {
    document.querySelector('.profile').addEventListener('click', function(event) {
               event.preventDefault();
               if(document.querySelector('.dropdown-menu')) document.querySelector('.dropdown-menu').classList.toggle('show');
           });
}   
 
if(document.querySelector('.dropdown-menu')) {
    document.addEventListener('click', function(event) {
        if (!document.querySelector('.profile-dropdown').contains(event.target)) {
            if(document.querySelector('.dropdown-menu')) document.querySelector('.dropdown-menu').classList.remove('show');
        }
    });
}