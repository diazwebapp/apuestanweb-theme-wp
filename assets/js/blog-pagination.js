document.addEventListener('DOMContentLoaded', () => {
    const paginationNumbers = document.querySelectorAll('#blog_pagination_list a.page-numbers');
   // const paginationNumberActive = document.querySelector('#blog_pagination_list span');
    const postsContainer = document.querySelector('#blog_posts_container'); // Contenedor de los posts

    if (paginationNumbers) {
        let paged = parseInt(pagination_data.paged)
        for(let number of paginationNumbers){
            
            number.addEventListener("click", e =>{
                e.preventDefault()
                //paginationNumberActive.classList.remove('current')
                for(let number2 of paginationNumbers){
                    number2.classList.remove('current')
                }
                number.classList.add('current')
                const target = e.target.closest('a');
                if(target.textContent == '>'){
                    paged++
                }else if(target.textContent == '<'){
                    paged--
                }else{
                    paged = parseInt(target.textContent)
                }
                console.log(paged)
                
                
                fetch(pagination_data.ajax_url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'blog_posts_pagination',
                        model: pagination_data.model,
                        paged,
                        post_type: 'post',
                        posts_per_page: pagination_data.perPage,
                        leagues : pagination_data.leagues,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            postsContainer.innerHTML = data.data.html;
                        } else {
                            console.error(data.data.message || 'Error fetching posts.');
                        }
                    })
                    .catch((err) => console.error('AJAX Error:', err));
                
            })
        }
        
    }

    
});
