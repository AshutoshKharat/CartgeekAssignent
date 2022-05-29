// -------- toggle sub menus --------
const navLinks = document.querySelectorAll(".nav__link");

navLinks.forEach((link) => link.addEventListener("click", drop));

function drop() {
  const subMenu = this.nextElementSibling;
  if (subMenu) {
    // if sub menu exists
    if (subMenu.style.height == "0px" || subMenu.style.height == "") {
      subMenu.style.height = subMenu.scrollHeight + "px";
      // open side nav
      sideNav.style.width = "14rem";
    } else {
      subMenu.style.height = "0px";
    }
  }
}

// --------- Toggle Side Nav --------
const menuBtn = document.querySelector("#nav-toggle");
const sideNav = document.querySelector("#side-nav");
const body = document.body;

menuBtn.addEventListener("click", toggleSideNav);

function toggleSideNav() {
  if (sideNav.style.width == "5.6rem" || sideNav.style.width == "") {
    sideNav.style.width = "15rem";
    body.style.marginLeft = "255px";
  } else {
    // close side nav
    sideNav.style.width = "5.6rem";
    body.style.marginLeft = "120px";
    // close all opened sub menus
    document
      .querySelectorAll(".nav__drop")
      .forEach((drop) => (drop.style.height = "0px"));
  }
}

jQuery(document).ready(function() {
    ImgUpload();
});

function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $('.upload__inputfile').each(function() {
        $(this).on('change', function(e) {
            imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
            var maxLength = $(this).attr('data-max_length');

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function(f, index) {

                if (!f.type.match('image.*')) {
                    return;
                }

                if (imgArray.length > maxLength) {
                    return false
                } else {
                    var len = 0;
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.append(html);
                            iterator++;
                        }
                        reader.readAsDataURL(f);
                    }
                }
            });
        });
    });

    $('body').on('click', ".upload__img-close", function(e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
    });
}
