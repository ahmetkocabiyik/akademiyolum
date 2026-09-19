/**
 * Alpine bileşenleri.
 *
 * Livewire kendi Alpine'ını yüklüyor; buraya yalnızca `alpine:init` üstünden
 * kayıt yapılır.
 */

document.addEventListener('alpine:init', () => {
    /**
     * Sayaç: elemanın İÇİNDEKİ sayıyı sıfırdan o sayıya kadar çıkarır.
     *
     * Hedefi sunucudan gelen metinden okur, `x-text` KULLANMAZ. Sebebi iki
     * tane: JavaScript çalışmazsa doğru sayı zaten ekranda durur, ve Livewire
     * DOM'u morph ettiğinde sunucunun değeri kazanır — animasyon eski bir
     * değeri ekranda dondurmaz.
     *
     * Biçimi bozmaz: animasyon biter bitmez orijinal metin (ör. "12 / 50")
     * geri yazılır.
     */
    window.Alpine.data('sayac', (sure = 700) => ({
        init() {
            const orijinal = this.$el.textContent;
            const hedef = parseInt(orijinal.replace(/[^\d-]/g, ''), 10);

            // Sayı yok ("—"), sıfır ya da kullanıcı hareket istemiyor: dokunma.
            if (!Number.isFinite(hedef) || hedef === 0) {
                return;
            }

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                return;
            }

            const baslangic = performance.now();

            const adim = (simdi) => {
                const oran = Math.min(1, (simdi - baslangic) / sure);
                // easeOutCubic — CSS'teki --ease-cikis ile aynı his.
                const yumusak = 1 - Math.pow(1 - oran, 3);

                if (oran < 1) {
                    this.$el.textContent = Math.round(hedef * yumusak).toString();
                    requestAnimationFrame(adim);
                } else {
                    this.$el.textContent = orijinal;
                }
            };

            requestAnimationFrame(adim);
        },
    }));
});
