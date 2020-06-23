# 1nd web project in 42.
##### This project is about creating an Instgram-like website.
User can use webcam or upload photo, add stickers and post to public gallery. Others can check, like, and comment.
##### P.S. THis is my very own first web project. Very ugly I know.
For this project, I spent a lot of time dealing with canvas, and multiple sticker layers and move and resize the stickers, all with Vanilla Java Script.

### Stacks:
* Front:
    * Vanilla JS
    * HTML & CSS
* Back:
    * Vanilla PHP
* Database:
    * MySQL

### Main Features:
* Register
    * email, username(3 - 15 characters) and pwd (Min 8 characters, at least one number, and one uppercase and lowercase letter)
    * Verify if username && email already exists
    * Verify if user fills all fields and if inputs are the right format as required
![Register](https://user-images.githubusercontent.com/45174444/85418082-a7899e00-b570-11ea-9764-0e81fb5523c3.png)
* An e-mail with an unique link to the registered user to verify and active his account before first login.
* Login with username or email and the right pwd.
* An e-mail with an unique link to re-initialize user's password if he request to reset the pwd.
* My Account page:
    * can change the information and email preference 
![myacount](https://user-images.githubusercontent.com/45174444/85418297-e9b2df80-b570-11ea-904c-b23dd8c54ce4.png)
* Public Gallery:
    * A gallery of all the pictures from all users. this is the page that open to the pulic. 
    * infinited pagination
    * Hover to each pictures can check the number of likes and comments
 ![public gallery](https://user-images.githubusercontent.com/45174444/85418946-c177b080-b571-11ea-91c3-586976f550e6.png)
* Single picture page:
    * A page to show single picture and likes and comments.
    * Public can access but only login users can like and comment.
![Single picture page](https://user-images.githubusercontent.com/45174444/85419216-15829500-b572-11ea-9819-5ad47817190e.png)
* Personal gallery:
    * Each user has own gallery that lists all the previous posted pictures. 
    * user can delete previous pictures.
![personal gallery](https://user-images.githubusercontent.com/45174444/85419406-58dd0380-b572-11ea-886b-0775f92fd985.png)
* New post Page:
    * can choose upload or take a picture through webcam. 
    * can add mulitple stickers from the stickers list, move and resize stickers on picture canvas.
    * live preview of the final effect.
    * will merge a final picture and confrim with user before post it to gallery. 
![newpost](https://user-images.githubusercontent.com/45174444/85419683-aeb1ab80-b572-11ea-869b-debcbad0761f.png)
![edit stckers](https://user-images.githubusercontent.com/45174444/85419669-ab1e2480-b572-11ea-8be3-96b65a539931.png)

### Run project

* The configuration is the following:
    * MySQL Database -> Port `3306`
    * Apache server -> Port `8080`
* Create DB: Localhost:8080/config/setup.php