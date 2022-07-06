
export default () => {

    document.addEventListener("DOMContentLoaded", () => {

        const form = document.querySelector("form");
        const inputFile = document.getElementById("upload-file__input_1");
    
    
            let textSelector = document.querySelector(".upload-file__text");
    
            // Событие выбора файла(ов)
            inputFile.addEventListener('change', ()=> {
                uploadFile(inputFile.files[0]);
            })
    
            // Проверяем размер файлов и выводим название
            const uploadFile = (file) => {
                // файла <5 Мб
                if (file.size > 5 * 1024 * 1024) {
                    alert("Файл должен быть не более 5 МБ.");
                    return;
                }
    
                // Показ загружаемых файлов
                 textSelector.textContent = file.name;
                
                
            }
    
        function send(event, php){
                let btn = document.getElementById('sendBtn');
                btn.value = "Мы отправляем ваше сообщение";
                event.preventDefault ? event.preventDefault() : event.returnValue = false;
                var req = new XMLHttpRequest();
                req.open('POST', php, true);
                req.onload = function() {
                    if (req.status >= 200 && req.status < 400) {
                    let json = JSON.parse(this.response); 
                      
                        
                        // ЗДЕСЬ УКАЗЫВАЕМ ДЕЙСТВИЯ В СЛУЧАЕ УСПЕХА ИЛИ НЕУДАЧИ
                        if (json.result == "success") {
                            // Если сообщение отправлено
                            btn.value = "Успех!";
                            
                        } else {
                            // Если произошла ошибка
                             btn.value = "Неудача!";
                        }
                    // Если не удалось связаться с php файлом
                    } else {alert("Ошибка сервера. Номер: "+req.status);}}; 
                
                // Если не удалось отправить запрос. Стоит блок на хостинге
                req.onerror = function() {alert("Ошибка отправки запроса");};
                req.send(new FormData(event.target));
         }
        // Отправка формы на сервер
 
        form.addEventListener('submit', (e) => {
            send(e,"../src/php/mail.php" )
   
        });
    
    });



}
