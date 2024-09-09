<?php

namespace App\Controllers;

class Contact 
{
    public function view()
    {
        return __DIR__.'/../Views/homepage.php';
    }
    public function managePostForm($post)
    {
        if (isset($post['email']) || isset($post['message'])) {
            $header  = 'MIME-Version: 1.0' . "\r\n";
            $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $header .= 'From: emailform@olindo-arcadia.fr' . "\r\n";
            $header .= 'Reply-to: '. $post['email'];
            
            $message = '<h1>Message envoyé depuis le formulaire du site web Arcadia</h1>
            <p><b>Email : </b>' . $post['email'] . '<br>
            <b>Message : </b>' . htmlspecialchars($post['message']) . '</p>';
            
            $emailToSend = mail('julien.martinati@gmail.com', htmlspecialchars($post['subject']), $message, $entete);
            if(!$emailToSend){
                return 'Probleme : Votre message n\'a pas été envoyé.';
            }
          }
    }
}