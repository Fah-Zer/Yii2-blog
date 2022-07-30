function findBurger() {
    const
        burger = document.querySelector('.burger'),
        burgerContent = document.querySelector('.burger-content'),
        burgerWidth = burger.offsetWidth,
        main = document.querySelector('.main')
    if (burgerWidth > 0) {
        burger.addEventListener('click', function () {
            burger.classList.toggle('active')
            burgerContent.classList.toggle('active')
            main.classList.toggle('inactive')
        })
    }
}

function findSpoilerNdropdown() {
    const
        spoilerNdropdown = document.querySelectorAll('.spoiler-dropdown')
    if (spoilerNdropdown.length > 0) {
        spoilerNdropdown.forEach(function (item) {
            const
                header = item.querySelector('.header'),
                plus = header.querySelector('.plus')
            if (plus !== null) {
                const
                    plusHeight = plus.offsetHeight
                if (plusHeight > 0) {
                    plus.addEventListener('click', function () {
                        item.classList.toggle('active')
                    })
                } else {
                    header.addEventListener('mouseover', function () {
                        item.classList.add('active')
                    })
                    item.addEventListener('mouseleave', function () {
                        item.classList.remove('active')
                    })
                }
            }
        })
    }
}

function findFileName() {
    const
        input = document.querySelector('input.hidden[type=file]'),
        label = document.querySelector('label.input')
    if (input !== null) {
        console.log('allright')
        input.addEventListener('change', function () {
            fileName = input.files[0].name
            label.innerHTML = fileName
        })
    }
}

findBurger()
findSpoilerNdropdown()
findFileName()