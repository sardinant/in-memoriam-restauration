property pSprite, pState, pBlend
global g, gL, gSp

on beginSprite me
  pSprite = sprite(me.spriteNum)
  pState = #wait
  pSprite.blend = 0
  pBlend = 0.0
  pSprite.visible = 1
  gSp.addProp(#PTNUMBERS, pSprite)
end

on prepareFrame me
  if gAskBusy() then
    case pState of
      #wait:
        nothing()
      #GOTOBLEND100:
        if pBlend < 100 then
          pBlend = min(100, pBlend + (200 * g.frameTime))
          pSprite.blend = pBlend
        else
          pState = #wait
        end if
    end case
  end if
end

on bGoToBlend100 me
  pState = #GOTOBLEND100
end
