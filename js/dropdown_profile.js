if(document.querySelector('.profile')) {
    document.querySelector('.profile').addEventListener('click', function(event) {
               event.preventDefault();
               document.querySelector('.dropdown-menu').classList.toggle('show');
           });
}   
 
        
        document.addEventListener('click', function(event) {
            if (!document.querySelector('.profile-dropdown').contains(event.target)) {
                document.querySelector('.dropdown-menu').classList.remove('show');
            }
        });