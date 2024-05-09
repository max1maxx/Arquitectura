@REM /*
@REM  * ----------------------------------------------------------------------------
@REM  * Propiedad de <Armando Josue Velasquez Delgado> <<https://armandovelasquez.com>>
@REM  * Todos los derechos reservados. Ninguna parte de este software puede ser 
@REM  * reproducida, distribuida o transmitida de ninguna forma o por ningún medio, 
@REM  * electrónico o mecánico, incluyendo fotocopias, grabaciones o cualquier otro 
@REM  * sistema de almacenamiento y recuperación de información, sin el permiso 
@REM  * previo por escrito del autor.
@REM  * ----------------------------------------------------------------------------
@REM  */

@echo off

REM Compila archivos SCSS específicos

REM Error
sass --update assets\scss\Error\_404.scss:assets\css\Error\404.css --load-path=assets\scss ^
&& (
    REM Login Admin
    sass --update assets\scss\Auth\_admin.scss:assets\css\Auth\admin.css --load-path=assets\scss ^
    && (
        REM Login User
        sass --update assets\scss\Auth\_user.scss:assets\css\Auth\user.css --load-path=assets\scss ^
        && (
            REM Perfil
            sass --update assets\scss\Account\_profile.scss:assets\css\Account\profile.css --load-path=assets\scss ^
            && (
                REM Home Admin
                sass --update assets\scss\Admin\_home.scss:assets\css\Admin\home.css --load-path=assets\scss ^
                && (
                    REM Home Public
                    sass --update assets\scss\Public\_home.scss:assets\css\Public\home.css --load-path=assets\scss ^
                    && (
                        REM User
                        sass --update assets\scss\Admin\_user.scss:assets\css\Admin\user.css --load-path=assets\scss
                    )
                )
            )
        )
    )
)