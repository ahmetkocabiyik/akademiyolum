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

/**
 * KART GEÇİŞLERİ (FLIP).
 *
 * Aday filtreyi ya da sıralamayı değiştirdiğinde Livewire listeyi yeniden
 * çiziyor ve kartlar bir karede yer değiştiriyordu: hangi üniversitenin
 * kaldığı, hangisinin düştüğü görülmüyordu. Burada klasik FLIP var — morph
 * ÖNCESİ konumlar ölçülür, morph SONRASI kart eski yerinden yenisine kaydırılır.
 *
 * Neden kartın kendi kimliğiyle (data-kart) anahtarlanıyor: morph düğümü
 * taşımak yerine yeniden kurarsa bile eski konum doğru kartla eşleşsin.
 *
 * Kapsam bilinçli olarak "kalan + yeni gelen": listeden ÇIKAN kart morph
 * bittiğinde DOM'da yok, animasyonu ancak klonlayarak yapılırdı. Kalanların
 * kayması zaten hangi kartın gittiğini anlatıyor.
 */
document.addEventListener('livewire:init', () => {
    const KART_SECICI = '[data-kart]';

    /** Morph öncesi konumlar; anahtar bileşen kökü (aynı sayfada iki liste olabilir). */
    const oncekiKonumlar = new WeakMap();

    const hareketKapali = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /**
     * CSS'teki hareket sözlüğünü JS'e taşır: süreler ve eğri tek yerde kalsın.
     * İlk çağrıda okunur, sonra saklanır.
     */
    let sozluk = null;
    const hareket = () => {
        if (sozluk) {
            return sozluk;
        }

        const kok = getComputedStyle(document.documentElement);
        const ms = (ad, varsayilan) => {
            const deger = kok.getPropertyValue(ad).trim();
            const sayi = parseFloat(deger);

            if (!Number.isFinite(sayi)) {
                return varsayilan;
            }

            // Token ms cinsinden yazılı; birim saniyeye çevrilirse de bozulmasın.
            return deger.endsWith('ms') ? sayi : sayi * 1000;
        };

        sozluk = {
            kayma: ms('--dur-yavas', 380),
            giris: ms('--dur-normal', 260),
            cikisEgrisi: kok.getPropertyValue('--ease-cikis').trim() || 'ease-out',
            girisEgrisi: kok.getPropertyValue('--ease-giris').trim() || 'ease-out',
        };

        return sozluk;
    };

    /**
     * Konum SAYFA koordinatında ölçülüyor, ekran koordinatında değil. Filtre
     * listeyi kısaltıp sayfa kendiliğinden yukarı kaydığında ekran farkı
     * kaymayı da içerir ve kartlar olmadık yerden uçar; sayfa koordinatı
     * yalnızca yerleşim değişimini verir.
     */
    const konumOlc = (kart) => {
        const kutu = kart.getBoundingClientRect();

        return { x: kutu.left + window.scrollX, y: kutu.top + window.scrollY };
    };

    Livewire.hook('morph', ({ el }) => {
        if (hareketKapali()) {
            return;
        }

        const kartlar = el.querySelectorAll(KART_SECICI);

        if (kartlar.length === 0) {
            return;
        }

        const konumlar = new Map();
        kartlar.forEach((kart) => konumlar.set(kart.dataset.kart, konumOlc(kart)));
        oncekiKonumlar.set(el, konumlar);
    });

    Livewire.hook('morphed', ({ el }) => {
        const konumlar = oncekiKonumlar.get(el);

        if (!konumlar) {
            return;
        }

        oncekiKonumlar.delete(el);

        const { kayma, giris, cikisEgrisi, girisEgrisi } = hareket();

        // Önce BÜTÜN ölçümler, sonra bütün animasyonlar. Araya yazma girerse
        // her kart için ayrı bir yerleşim hesabı tetiklenir; yüzlerce kartlık
        // listede fark gözle görülür.
        const olcumler = [...el.querySelectorAll(KART_SECICI)]
            .map((kart) => [kart, konumlar.get(kart.dataset.kart), konumOlc(kart)]);

        olcumler.forEach(([kart, eski, yeni]) => {
            // Listeye yeni giren kart: yerinde belirsin.
            if (!eski) {
                kart.animate(
                    [
                        { opacity: 0, transform: 'scale(0.97)' },
                        { opacity: 1, transform: 'none' },
                    ],
                    { duration: giris, easing: girisEgrisi },
                );

                return;
            }

            const dx = eski.x - yeni.x;
            const dy = eski.y - yeni.y;

            // Yerinde duran kart (ör. detay paneli açıldı) animasyon istemiyor.
            if (Math.abs(dx) < 1 && Math.abs(dy) < 1) {
                return;
            }

            kart.animate(
                [
                    { transform: `translate(${dx}px, ${dy}px)` },
                    { transform: 'none' },
                ],
                { duration: kayma, easing: cikisEgrisi },
            );
        });
    });
});
