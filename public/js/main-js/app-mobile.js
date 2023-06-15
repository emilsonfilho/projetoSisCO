if (window.innerWidth <= 999) {
		const navList = document.querySelector(".nav-list")
		const dropdown = document.querySelector("#dropdown")
		const btnSair = document.querySelector("li#sair")
		dropdown.parentNode.removeChild(dropdown)
		
		const dropdownItems = dropdown.querySelectorAll("li")
		btnSair.parentNode.removeChild(btnSair)
		for (let i = 0; i < dropdownItems.length; i++) {
				let item = dropdownItems[i]
				let text = item.textContent.toLowerCase()
				let capitalized = text.charAt(0).toUpperCase() + text.slice(1)
				
				let link = item.querySelector("a") 
				let url = link.getAttribute("href")  
				
				link.textContent = `Cadastro de ${capitalized}`
			
				item.appendChild(link)
				navList.appendChild(item)
		}
		navList.appendChild(btnSair)
		
		
		const a = document.querySelector("a.logo")
		a.style.marginRight = 48 + "px"
		const menu = document.querySelector("div.mobile-menu")
		menu.style.marginLeft = 48 + "px"
}
