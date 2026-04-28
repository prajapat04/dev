
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected', 'false'); });
        tab.classList.add('active'); tab.setAttribute('aria-selected', 'true');
        document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
        document.getElementById('panel-' + tab.dataset.tab).style.display = 'block';
        document.getElementById('resultSection').classList.remove('show');
      });
    });

    const searchBtn = document.getElementById('searchBtn');
    const resultSection = document.getElementById('resultSection');

    searchBtn.addEventListener('click', () => {
      const activePanel = document.querySelector('.tab-panel:not([style*="display: none"])');
      const input = activePanel ? activePanel.querySelector('.form-input') : null;
      if (input && input.value.trim() === '') {
        input.style.borderColor = '#e8192c';
        input.style.boxShadow = '0 0 0 3px rgba(232,25,44,0.15)';
        input.focus();
        setTimeout(() => { input.style.borderColor = ''; input.style.boxShadow = ''; }, 2000);
        return;
      }
      searchBtn.classList.add('loading'); searchBtn.disabled = true;
      resultSection.classList.remove('show');
      setTimeout(() => { searchBtn.classList.remove('loading'); searchBtn.disabled = false; resultSection.classList.add('show'); }, 1600);
    });

    document.querySelectorAll('.form-input').forEach(input => {
      input.addEventListener('keydown', e => { if (e.key === 'Enter') searchBtn.click(); });
      input.addEventListener('input', function () {
        const s = this.selectionStart, e = this.selectionEnd;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(s, e);
      });
    });



    function toggleAcc(btn) {
      const item = btn.closest('.acc-item');
      const isOpen = item.classList.contains('open');
      // close all
      document.querySelectorAll('.acc-item').forEach(i => i.classList.remove('open'));
      // open clicked if it was closed
      if (!isOpen) item.classList.add('open');
    }
    function toggleMenu() {
      const hamburger = document.getElementById('hamburger');
      const navLinks = document.getElementById('navLinks');


      hamburger.classList.toggle('open');
      navLinks.classList.toggle('open');


      document.body.style.overflow =
        navLinks.classList.contains('open') ? 'hidden' : '';
    }
    
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', function(e) {
    if (this.closest('.has-dropdown') && window.innerWidth <= 768) {
      return; 
    }

    const hamburger = document.getElementById('hamburger');
    const navLinks  = document.getElementById('navLinks');

    hamburger.classList.remove('open');
    navLinks.classList.remove('open');
    document.body.style.overflow = '';
  });
});


// Mobile dropdown toggle
document.querySelectorAll('.has-dropdown > a').forEach(link => {
  link.addEventListener('click', function(e) {
    if (window.innerWidth <= 768) {
      e.preventDefault();
      e.stopPropagation();

      const li = this.closest('.has-dropdown');
      const isOpen = li.classList.contains('open');

      
      document.querySelectorAll('.has-dropdown').forEach(el => {
        el.classList.remove('open');
      });

     
      if (!isOpen) {
        li.classList.add('open');
      }
    }
  });
});

// Close menu on nav link click
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', function(e) {
    if (this.closest('.has-dropdown') && window.innerWidth <= 768) {
      return;
    }

    const hamburger = document.getElementById('hamburger');
    const navLinks  = document.getElementById('navLinks');

    hamburger.classList.remove('open');
    navLinks.classList.remove('open');
    document.body.style.overflow = '';
  });
});


 // Challan amounts
    const amounts = { card1: 1000, card2: 1000, card3: 500 };
    const selected = { card1: true, card2: true, card3: true };

    function updateSummary() {
      let total = 0;
      let count = 0;
      Object.keys(selected).forEach(k => {
        if (selected[k]) { total += amounts[k]; count++; }
      });
      document.getElementById('totalAmount').textContent = '₹' + total.toLocaleString('en-IN');
      document.getElementById('payAmount').textContent   = '₹' + total.toLocaleString('en-IN');
      document.querySelector('.payment-title').textContent = 'Payment Summary';
      document.querySelector('.payment-row-label').textContent = `Challans Selected (${count})`;
    }

    function toggleAdd(btn, cardId) {
      selected[cardId] = !selected[cardId];
      const card = document.getElementById(cardId);
      if (selected[cardId]) {
        btn.textContent = 'Added';
        btn.classList.add('added');
        card.classList.add('selected');
      } else {
        btn.textContent = 'Add to Pay';
        btn.classList.remove('added');
        card.classList.remove('selected');
      }
      updateSummary();
    }

    function toggleExpand(cardId) {
      const card = document.getElementById(cardId);
      card.classList.toggle('expanded');
      lucide.createIcons();
    }

    function resetSearch() {
      document.getElementById('challanInput').value = '';
    }

    function checkStatus() {
      const val = document.getElementById('challanInput').value.trim();
      if (!val) {
        document.getElementById('challanInput').style.borderColor = 'var(--red)';
        setTimeout(() => document.getElementById('challanInput').style.borderColor = '', 2000);
      }
    }

    
    lucide.createIcons();